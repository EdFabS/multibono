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

class Form_Descarga_Controller extends Controller
{
    //
    public function descarga($campana = 'default'){
    	$campana_for_vista = DB::select('select * from campanas where campana = \''.$campana.'\'');
    	//por si entra a la ruta sin campaña
    	if(isset($campana_for_vista) and !empty($campana_for_vista)){
    	$campana = array($campana_for_vista[0]->id);
		$imagen_logo= array($campana_for_vista[0]->url_img_logo);
		$imagen_head= array($campana_for_vista[0]->url_img_head);
		$titulo = array($campana_for_vista[0]->titulo);
		$description = array($campana_for_vista[0]->descripcion);
		$legales = array($campana_for_vista[0]->legales);
    	return view('descarga/bono')
	    		->with('campana', $campana)
	    		->with('imagen_logo', $imagen_logo)
	    		->with('imagen_head', $imagen_head)
	    		->with('titulo', $titulo)
	    		->with('description', $description)
	    		->with('legales', $legales);
    	}else{
	        abort(500);
	    }
    }
}
