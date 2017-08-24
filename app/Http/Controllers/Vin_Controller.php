<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use DB;
use App\Vin;
use App\Folio;
use Session;

class Vin_Controller extends Controller
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
    public function vin(){
    	$campanas = DB::Table('campanas')
    		->get();
    	$campanas_array[] = array('id' => '', 'campana' => 'selecciona una opción');
    	foreach ($campanas as $campana) {
    		$campanas_array[] = array('id' => $campana->id, 'campana' =>$campana->campana);
    	}
    	return view('vins/vin')->with('campanas', $campanas_array);
    }
    //
    public function addVin(Request $request){
    	$this->validate($request, [
    		'vin'=>'required|alpha_num|min:17|max:17',
    		'id_campana'=>'required',
    		]);
    	//var_dump($request);
    	$llave = md5($request->vin.'-'.$request->id_campana);
    	//checamos si no existe este vin en la campaña actual
    	$exist_llave = DB::select('select * from vins where llave =\''.$llave.'\'');
    	if(empty($exist_llave)) {
    		//insertar en base de datos
	    	$vin = new Vin;
	    	$vin->vin = $request->vin;
	    	$vin->id_campana = $request->id_campana;
	    	$vin->llave = $llave;
	    	$vin->save();
	    	//generar folio
	    	//obtenemos los datos de este registro para guardar folio en la tabla folios
	    	$id = DB::selectOne('SELECT LAST_INSERT_ID() as "id"');

	    	$folio_rand = $this->RandomString(10, true, true, false);
	        $existe_folio = DB::select('select folio from folios where folio = \''.$folio_rand.'\'');
	        while(!empty($existe_folio)){
	            $folio_rand = $this->RandomString(10,true,true,false);
	            $existe_folio = DB::select('select folio from folios where folio = \''.$folio_rand.'\'');
	        }
	        $folio = new Folio;
	        $folio->folio = $folio_rand;
	        $folio->id_vin = $id->id;
	        $folio->save();
	        DB::table('vins')
	        ->where('llave', '=', $llave)
	        ->update(['flag_folio' => true]);

	    	Session::flash('registro_guardado', 'Se guardó exitosamente');
	        return redirect('/vin');
    	}
    	else{
    		Session::flash('registro_repetido', 'Ya existe este registro');
	        return redirect('/vin');
    	}
    }

    //funcion generadora de folio de 10 digitos
    function RandomString($length=10,$uc=TRUE,$n=TRUE,$sc=FALSE)
	{
	   $token = "";
	    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
	    $codeAlphabet.= "0123456789";
	    $max = strlen($codeAlphabet); // edited

	    for ($i=0; $i < $length; $i++) {
	        $token .= $codeAlphabet[$this->crypto_rand_secure(0, $max-1)];
	    }

	    return $token;
	}

	function crypto_rand_secure($min, $max)
	{
	    $range = $max - $min;
	    if ($range < 1) return $min; // not so random...
	    $log = ceil(log($range, 2));
	    $bytes = (int) ($log / 8) + 1; // length in bytes
	    $bits = (int) $log + 1; // length in bits
	    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
	    do {
	        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
	        $rnd = $rnd & $filter; // discard irrelevant bits
	    } while ($rnd > $range);
	    return $min + $rnd;
	}
}
