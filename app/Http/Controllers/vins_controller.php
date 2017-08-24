<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use DB;
use Excel;
use App\Folio;
use Illuminate\Support\Facades\Input;

class Vins_Controller extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
        if (isset(Auth::user()->role)) {
        	if(Auth::user()->role != 'admin' and Auth::user()->role != 'service') {
            	Auth::logout();
        	}
        }
    }
    //
    public function vins(){
    	$campanas = DB::Table('campanas')
    		->get();
    	$campanas_array[] = array('id' => '', 'campana' => 'selecciona una opción');
    	foreach ($campanas as $campana) {
    		$campanas_array[] = array('id' => $campana->id, 'campana' =>$campana->campana);
    	}
    	return view('vins/vins')->with('campanas', $campanas_array);
    }

    public function addVins(Request $request){
    	$this->validate($request, [
    		'file'=>'required',
    		'id_campana'=>'required'
    		]);
    	//cacha el archivio pasado por post
        $file = Input::file('file');
        $file_name = $file->getClientOriginalName();
        //mueve el archivo a la carpeta public/files
        $file->move('files', $file_name);
        //obtiene el contenido del archivo
        $results = Excel::load('files/'.$file_name, function($reader){
            $reader->all();
        })->get();
        foreach ($results as $row) {
            //recorremos el archivo
            $query = ' insert into vins (vin, id_campana, llave, mail, flag_folio, created_at, updated_at) values (\''.$row->vin.'\','.$request->id_campana.',\''.md5($row->vin.'-'.$request->id_campana).'\',\''.$row->email.'\',false,\''.\Carbon\Carbon::now().'\',\''.\Carbon\Carbon::now().'\');';
            DB::insert($query);
        }
        Session::flash('registros_guardados', 'Se proceso correctamente el archivo, procede a generar FOLIOS');
	        return redirect('/vins');
    }
}
