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
use Illuminate\Support\Facades\Input;
use Storage;
use File;
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
            // 'campana'=>'required|alpha_num|unique:campanas',
            // 'id_unidad'=>'required',
            // 'url_img_logo' => 'required|unique:campanas',
            // 'url_img_head' => 'required|unique:campanas',
            'titulo' => 'required',
            'descripcion' => 'required',
            'legales' => 'required'
            ]);

        //guardamos las imagenes en local y ruta en base de datos
        Storage::makeDirectory('public/'.$request->campana);
        $file = Input::file('url_img_logo');
        $file_name = $file->getClientOriginalName();
        $file->move('files/campanas', $file_name);
        $url_logo = "/files/campanas/".$file_name;
        echo $url_logo;
        
        $file = Input::file('url_img_head');
        $file_name = $file->getClientOriginalName();
        $file->move('files/campanas', $file_name);
        $url_head = "/files/campanas/".$file_name;
        echo $url_head;

        //cambiamos texto a codigo etiqueta para que sea interpretado

        $titulo = $request->titulo;
        $descripcion = $request->descripcion;
        $legales = $request->legales;

        //reemplazar acentos por codigo html
        $titulo_replace = $this->tildesHTML($titulo);
        $descripcion_replace = $this->tildesHTML($descripcion);
        $legales_replace = $this->tildesHTML($legales);
        //reemplazar simbolo de registro
        $titulo_replace = $this->regHTML($titulo_replace);
        $descripcion_replace = $this->regHTML($descripcion_replace);
        $legales_replace = $this->regHTML($legales_replace);

        //guardamos en base de datos

         $campana = new Campana;
        $campana->campana = $request->campana;
        $campana->id_unidad = $request->id_unidad;
        $campana->url_img_logo = $url_logo;
        $campana->url_img_head = $url_head;
        $campana->titulo = $titulo_replace;
        $campana->descripcion = $descripcion_replace;
        $campana->legales = $legales_replace;
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
           if (!empty($request->$id_modelo)){
                //insertar el modelo y la campana en campana_modelos

               $campana_modelo = new CampanaModelo;
               $campana_modelo->id_modelo = $id_modelo;
               $campana_modelo->id_campana = $campana_db[0]->id;
               $campana_modelo->save();

           }
        }
        
        //creamos el directorio , submos las imagenes a la carpeta correspondiente y inyectamos en DB ruta de los archivos
        //crear carpeta de campaña 

        Session::flash('registro_guardado', 'Se ha guardado correctamente como nuevo registro');
        return redirect('/campanas');
    }

    public function tildesHTML($cadena){
        return str_replace(
            array("á","é","í","ó","ú","ñ","Á","É","Í","Ó","Ú","Ñ"),
            array("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&ntilde;",
            "&Aacute;","&Eacute;","&Iacute;","&Oacute;","&Uacute;","&Ntilde;"), 
            $cadena);
    }

    public function regHTML($cadena){
        return str_replace("®","<sup>&reg;</sup>", 
            $cadena);
    }
}