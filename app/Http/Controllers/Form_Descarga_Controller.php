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
    	$campana_db = DB::selectOne('select * from campanas where campana = \''.$campana.'\'');
    	var_dump($campana_db);
    	//por si entra a la ruta sin campaña
    	if(isset($campana_db) and !empty($campana_db)){
    	$title = array($campana);
    	$campana = $campana_db;
    	return view('descarga/bono')
    			->with('title', $title)
	    		->with('campana', $campana);
    	}else{
	        return view('errors/default');
	    }
    }
}
