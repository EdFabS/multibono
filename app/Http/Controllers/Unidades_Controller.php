<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use DB;
use Session;
use Redirect;

class Unidades_Controller extends Controller
{
    //controler para listar y agregar nuevas unidades de negocio
    public function __construct()
    {
        $this->middleware('auth');
        if (isset(Auth::user()->role)) {
        	if(Auth::user()->role != 'admin') {
            	Auth::logout();
        	}
        }
    }
    //lista y crea unidades
    public function unidades(){
    	$unidades = DB::Table('unidads')
    		->orderBy('unidad', 'asc')
    		->get();
    	return view('admin_service/crear_unidad')->with('unidades', $unidades);
    }
    //crea unidades de negocio
    public function crear_unidad(Request $request){
    	$this->validate($request, [
    		'unidad'=>'required|alpha_num|unique:unidads',
    		]);
    	$request->all();
   		$unidad = new Unidad;
   		$unidad->unidad = $request->unidad;
   		$unidad->save();
   		Session::flash('registro_guardado', 'Se ha guardado correctamente como nuevo registro');
	        return redirect('/unidades');
    }
}
