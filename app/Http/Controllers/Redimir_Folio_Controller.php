<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Session;
use Validator;
use App\Redimido;
use App\New_vin_redimido;

class Redimir_Folio_Controller extends Controller
{
	public function folio_form($folio_request){
		//obtenemos los datos necesarios para el gormulario
		$folio = DB::selectOne('select v.id, f.folio, v.vin, v.id_campana,  v.llave, v.mail from folios f inner join vins v on v.id = f.id_vin where f.folio = \''.$folio_request.'\'');
		$dealers_db = DB::select('select id, dealer from dealers order by dealer asc');
		$campana_db = DB::selectOne('select * from campanas where id = '.$folio->id_campana);
		$campana = array('id_campana'=>$campana_db->id, 'campana'=>$campana_db->campana, 'logo'=>$campana_db->url_img_logo, 'head'=>$campana_db->url_img_head, 'titulo'=> $campana_db->titulo);
		$modelos_db = DB::select('select m.id, m.modelo from campana_modelos cm inner join modelos m on m.id = cm.id_modelo where id_campana ='.$folio->id_campana);
		Session::flash('folio_valido', 'Folio valido');
        return view('folios/redimir_folio')
            ->with('campana', $campana)
            ->with('dealers', $dealers_db)
            ->with('modelos_vins', $modelos_db)
            ->with('folio', $folio);
	}
    //
    public function redimir(Request $request){
    	Validator::extend('alpha_spaces', function($attribute, $value)
		{
		    return preg_match('/^[\pL\s]+$/u', $value);
		});
    	$this->validate($request,[
    		'fullname'=>'required|alpha_spaces',
    		'parentesco'=>'required',
    		'distribuidor'=>'required',
    		'salesman'=>'required|alpha_spaces',
    	 	'new_vin.*.vin'=>'alpha_num|min:17|max:17',
    	 	'id_folio' => 'required|unique:redimidos'
    		]);
        $fullname = $request->fullname;
        $parentesco = $request->parentesco;
        $id_distribuidor = $request->distribuidor;
        $salesman = $request->salesman;
        $new_vins = $request->new_vin;
        $id_folio = $request->id_folio;

        $modelos = DB::select('select id_modelo from campana_modelos where id_campana = '.$request->id_campana);
        var_dump($modelos);

        $insert_redimido = new Redimido;
        $insert_redimido->id_folio = $id_folio;
        $insert_redimido->fullname = $fullname;
        $insert_redimido->parentesco = $parentesco;
        $insert_redimido->id_distribuidor = $id_distribuidor;
        $insert_redimido->vendedor = $salesman;
        $insert_redimido->save();

        foreach ($modelos as $modelo) {
        	if (!empty($new_vins[$modelo->id_modelo]['vin'])) {
        		$insert_modelo_redimido = new New_vin_redimido;
        		$insert_modelo_redimido->id_folio = $id_folio;
        		$insert_modelo_redimido->$new_vins[$modelo->id_modelo]['vin'];
        		$insert_modelo_redimido->id_modelo=$modelo->id_modelo;
        		$insert_modelo_redimido->save();
        	}
        }
        $campana_for_vista = DB::selectOne('select * from campanas where id ='.$request->id_campana);
        Session::flash('folio_valido', 'Folio redimido correctamente');
        return redirect('/folio/'.$campana_for_vista->campana)
            ->with('campana', $campana_for_vista->id)
            ->with('imagen_logo', $campana_for_vista->url_img_logo)
            ->with('imagen_head', $campana_for_vista->url_img_head);
    }
}
