<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Session;

class Folio_Controller extends Controller
{
    //
    public function folio($campana = 'default'){
    	$campana_for_vista = DB::select('select * from campanas where campana = \''.$campana.'\'');
        //por si entra a la ruta sin campaña
        if(isset($campana_for_vista) and !empty($campana_for_vista)){
            $campana = array($campana_for_vista[0]->id);
            $imagen_logo= array($campana_for_vista[0]->url_img_logo);
            $imagen_head= array($campana_for_vista[0]->url_img_head);
            return view('folios/folio')
                ->with('campana', $campana)
                ->with('imagen_logo', $imagen_logo)
                ->with('imagen_head', $imagen_head);
        }else{
            abort(500);
        }
    }

    public function buscar_folio(Request $request){
    	$this->validate($request,[
    		'folio'=>'required|alpha_num|min:10|max:10|exists:folios'
    		]);
    	$folio = DB::selectOne('select f.id, f.folio, v.vin, v.id_campana,  v.llave, v.mail from folios f inner join vins v on v.id = f.id_vin where f.folio = \''.$request->folio.'\'');
        var_dump($folio);
        $redimido = DB::selectOne('select * from redimidos where id_folio = '.$folio->id);
        var_dump($redimido);
        if(!empty($redimido)){
            $campana_for_vista = DB::selectOne('select * from campanas where id ='.$request->id_campana);
            Session::flash('folio_invalido', 'Folio ya ha sido redimido');
            return redirect('/folio/'.$campana_for_vista->campana)
                ->with('campana', $campana_for_vista->id)
                ->with('imagen_logo', $campana_for_vista->url_img_logo)
                ->with('imagen_head', $campana_for_vista->url_img_head);
            }else{
                if($folio->id_campana != $request->id_campana){
                    $campana_for_vista = DB::selectOne('select * from campanas where id ='.$request->id_campana);
                    Session::flash('folio_invalido', 'Folio no correspondiente a esta campaña');
                    return redirect('/folio/'.$campana_for_vista->campana)
                        ->with('campana', $campana_for_vista->id)
                        ->with('imagen_logo', $campana_for_vista->url_img_logo)
                        ->with('imagen_head', $campana_for_vista->url_img_head);
                }
                else{
                    return redirect('folio_form/'.$request->folio);
                }
            }
    }
}
