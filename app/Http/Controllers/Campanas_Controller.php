<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use DB;
use App\Campana;
use App\CampanaModelo;
use Session;
use Redirect;

class Campanas_Controller extends Controller
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
    //
    public function campanas(){
        $campanas = DB::select('select c.campana, u.unidad, (select group_concat(m.modelo) from modelos m inner join campana_modelos cm on cm.id_modelo = m.id where cm.id_campana = c.id) as modelos from campanas c inner join unidads u on u.id = c.id_unidad;');
        $unidades = DB::Table('unidads')
            ->orderBy('unidad', 'asc')
            ->get();
        $modelos = DB::Table('modelos')
            ->orderBy('modelo', 'asc')
            ->get();
        return view('admin_service/crear_campana')
            ->with('campanas', $campanas)
            ->with('modelos', $modelos)
            ->with('unidades', $unidades);
    }
    //
    public function crear_campana(Request $request){
        $this->validate($request, [
            'campana'=>'required|alpha_num|unique:campanas',
            'id_unidad'=>'required'
            ]);
        $request->all();
        $campana = new Campana;
        $campana->campana = $request->campana;
        $campana->id_unidad = $request->id_unidad;
        $campana->save();
        //obtengo el id del registro de la campaña creada para poder agregar a la tabla campana-modelos
        $campana_db = DB::Table('campanas')
            ->where('campana', $request->campana)
            ->get();
        //llamar modelos para comparar cuales son los que se asociaran con la campaña
        $modelos_db = DB::Table('modelos')
            ->get();
        foreach ($modelos_db as $key) {
            $id_modelo = $key->id;
            if ($request->$id_modelo != NULL){
                //insertar el modelo y la campana en campana_modelos
                $campana_modelo = new CampanaModelo;
                $campana_modelo->id_modelo = $id_modelo;
                $campana_modelo->id_campana = $campana_db[0]->id;
                $campana_modelo->save();
            }
        }
        Session::flash('registro_guardado', 'Se ha guardado correctamente como nuevo registro');
        return redirect('/campanas');
    }
}
