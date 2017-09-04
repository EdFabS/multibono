<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use DB;
use App\ReporteDescarga;

class Reportes_Controller extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        if (isset(Auth::user()->role)) {
        	if(Auth::user()->role != 'admin' and Auth::user()->role != 'service' and Auth::user()->role != 'gm' and Auth::user()->role != 'gmf') {
            	Auth::logout();
        	}
        }
    }
    public function reportes(){
    	return view('reportes/reportes');
    }

    public function descargas(){
    	// mostrar reporte de descargas
    	if(Auth::user()->role != 'admin' and Auth::user()->role != 'service'){
    		//campañas por unidad
    		$campanas = DB::select('select * from campanas c inner join unidads u on u.id = c.id_unidad where u.unidad =\''.Auth::user()->role.'\'');
    	}elseif (Auth::user()->role == 'admin' or Auth::user()->role == 'service') {
    		//todas las campañas
    		$campanas = DB::select('select * from campanas');
    	}
    	
    	//var_dump($campanas);
    	return view('reportes/descargas')
    		->with('campanas', $campanas);
    }

    public function reporte_descargas($id_campana){
    	//var_dump($id_campana);
    	$descargados = DB::select('select v.vin, f.folio, v.mail, d.descargas, v.updated_at from downloads d inner join vins v on v.llave = d.llave inner join folios f on v.id = f.id_vin where v.id_campana = \''.$id_campana.'\'');
    	//var_dump($descargados);

    	ReporteDescarga::truncate();
        foreach ($descargados as $row) {
            ReporteDescarga::create(array('vin' => $row->vin, 'folio' => $row->folio, 'mail' => $row->mail, 'descargas' => $row->descargas, 'fecha' => $row->updated_at));
        }

        $descargados = ReporteDescarga::paginate(20);

        return view('reportes/descargas_por_campana')
            ->with('descargados', $descargados);



    }

    public function redimidos(){
    	//return view('reportes/redimidos')
    }
}
