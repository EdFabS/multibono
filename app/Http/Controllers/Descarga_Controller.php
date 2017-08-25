<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use DB;
use Setasign\Fpdf\FPDF;
use Setasign\Fpdi\FPDI;
use App\Download;
use Session;

class Descarga_Controller extends Controller
{
    //
    public function descarga_bono(Request $request){
    	$this->validate($request, [
    		'vin'=> 'required|alpha_num|min:17|exists:vins|max:17',
    		'terminos'=>'required'
    		]);
    	$vin_para_bono = DB::select('select * from vins where id_campana = \''.$request->id_campana.'\' and llave = \''.md5($request->vin.'-'.$request->id_campana).'\';');
    	var_dump($vin_para_bono);
    	if(!empty($vin_para_bono)){
	    	$vin_folio = DB::select('select  v.id, f.folio, v.vin, v.llave  from folios f inner join vins v on v.id = f.id_vin where v.id = '.$vin_para_bono[0]->id);
	    	//insertar en descargas
	    	$bono_descargado = DB::selectOne('select * from downloads where llave = \''.$vin_folio[0]->llave.'\'');
	    	if (empty($bono_descargado)) {
	    		$bono_insertar = new Download;
	    		$bono_insertar->llave = $vin_folio[0]->llave;
	    		$bono_insertar->descargas = 1;
	    		$bono_insertar->save();
	    	}
	    	else{
	    		var_dump($bono_descargado);
	    		$contador = $bono_descargado->descargas + 1;
	    		$descarga_update = Download::find($bono_descargado->id);
			    $descarga_update->descargas = $contador;
			    $descarga_update->save();
	    	}
	    	$this->generacion_pdf($request->id_campana, $vin_folio[0]->folio);
	    }else{
	    	var_dump($request->id_campana);
	    	$campana = DB::selectOne('select * from campanas where id = '.$request->id_campana);
	    	if(!empty($campana)){
	    		Session::flash('vin_invalido', 'Vin invalido o no existe en esta promoción');
	        	return redirect('/descarga/'.$campana->campana);
	    	}else{
	    		Session::flash('vin_invalido', 'Vin invalido o no existe en esta promoción');
	        	return redirect('/descarga');
	    	}
	    }
    }

    //funcion generadora del bono pdf
    public function generacion_pdf($campana, $folio, $fuente = 'Arial'){
    	$template_pdf = public_path()."/files/certificado_template".$campana.".pdf";
    	$pdf = new FPDI('L', 'mm', array(139.7, 215.9));
    	//cargamos el bono
		$pdf->setSourceFile($template_pdf);
		//agregamos una pagina
		$pdf->AddPage();
		// seleccionamos la primera pagina del docuemnto importado
		$tplIdx = $pdf->importPage(1);
		// // usamos la pagina importado como template
		$pdf->useTemplate($tplIdx);
		// #$pdf->SetXY(60,191.5);  // en bajas
		$pdf->SetXY(82.5,7.5);
		//
		$pdf->SetFont($fuente,'BI',12);
		//
		$pdf->SetTextColor(255,255,255);	
		    //escribimos el numero de recibo
		$pdf->Write(0, 'FOLIO: '.$folio);
		ob_end_clean();
		//descargamos el archivo
		$pdf->Output('bono-'.$folio.'.pdf', 'D');
    }
}
