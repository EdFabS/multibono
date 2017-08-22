<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use DB;
use App\Modelo;
use Session;
use Redirect;

class Modelo_Controller extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
        if (isset(Auth::user()->role)) {
        	if(Auth::user()->role != 'admin') {
            	Auth::logout();
        	}
        }
    }

    public function modelos(){
        $modelos = DB::Table('modelos')
            ->orderBy('modelo', 'asc')
            ->get();
        return view('admin_service/crear_modelo')
            ->with('modelos', $modelos);
    }
    //
    public function crear_modelo(Request $request){
        $this->validate($request, [
            'modelo'=>'required|alpha_num|unique:modelos'
            ]);
        $request->all();
        $modelo = new Modelo;
        $modelo->modelo = $request->modelo;
        $modelo->save();
        Session::flash('registro_guardado', 'Se ha guardado correctamente como nuevo registro');
            return redirect('/modelos');
    }
}
