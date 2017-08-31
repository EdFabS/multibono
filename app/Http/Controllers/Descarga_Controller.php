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
    	if(!empty($vin_para_bono)){
	    	$vin_folio = DB::select('select  v.id as id_vin, f.id as id_folio, f.folio, v.vin, v.llave  from folios f inner join vins v on v.id = f.id_vin where v.id = '.$vin_para_bono[0]->id);
	    	$redimido = DB::selectOne('select * from redimidos where id_folio = '.$vin_folio[0]->id_folio);
	    	//verificaion si h ya ha sido redimido
	    	if(!empty($redimido)){
	    		$campana = DB::selectOne('select * from campanas where id = '.$request->id_campana);
		    	if(!empty($campana)){
		    		Session::flash('vin_invalido', 'el Folio generado con este VIN ha sido REDIMIDO');
		        	return redirect('/descarga/'.$campana->campana);
		    	}
		    }
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

    public function descarga_folio($folio){
    	$folio_db = DB::selectOne('select id, folio, id_vin from folios where folio = \''.$folio.'\'');
    	if(empty($folio_db)){
    		Session::flash('vin_invalido', 'El folio invalido');
	        	return redirect('/');
    	}
    	$redimido = DB::selectOne('select * from redimidos where id_folio = '.$folio_db->id);
    	//verificaion si h ya ha sido redimido
    	if(!empty($redimido)){
	    		Session::flash('vin_invalido', 'el Folio generado con este VIN ha sido REDIMIDO');
	        	return redirect('/');
	    }else{
	    	$vin_folio = DB::selectOne('select * from vins where id = '.$folio_db->id_vin);
	    	var_dump($vin_folio);
	    	//insertar en descargas
	    	$bono_descargado = DB::selectOne('select * from downloads where llave = \''.$vin_folio->llave.'\'');
	    	if (empty($bono_descargado)) {
	    		$bono_insertar = new Download;
	    		$bono_insertar->llave = $vin_folio->llave;
	    		$bono_insertar->descargas = 1;
	    		$bono_insertar->save();
	    	}
	    	else{
	    		$contador = $bono_descargado->descargas + 1;
	    		$descarga_update = Download::find($bono_descargado->id);
			    $descarga_update->descargas = $contador;
			    $descarga_update->save();
	    	}
	    	$this->generacion_pdf($vin_folio->id_campana, $folio_db->folio);
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
