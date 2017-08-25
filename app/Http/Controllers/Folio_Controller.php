<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class Folio_Controller extends Controller
{
    //
    public function folio(){
    	return view('folios/folio');
    }

    public function buscar_folio(Request $request){
    	$this->validate($request,[
    		'folio'=>'required|alpha_num|min:10|max:10|exists:folios',
    		]);
    	$folio = DB::selectOne('select v.id, f.folio, v.vin, v.id_campana,  v.llave, v.mail from folios f inner join vins v on v.id = f.id_vin where f.folio = \''.$request->folio.'\'');
    	$def_camp = array('folio' => $folio);
    	return view('folios/redimir_folio');
    }
}
