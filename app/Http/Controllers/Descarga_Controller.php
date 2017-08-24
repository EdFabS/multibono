<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use DB;

class Descarga_Controller extends Controller
{
    //
    public function descarga($campana = 'default'){
    	$campana_for_vista = DB::select('select * from campanas where campana = \''.$campana.'\'');
    	//por si entra a la ruta sin campaña
    	if(isset($campana_for_vista) and !empty($campana_for_vista)){
    		switch ($campana_for_vista[0]->campana) {
	    		case 'sonic':
	    			$campana = array($campana);
					$imagenes = array(1 => 'default_uno.png', 2 => 'default_dos.png' );
					$titulo = array(1 => 'BONO DE LEALTAD SONIC');
					$description = array(1 => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi non quis exercitationem culpa nesciunt nihil aut nostrum explicabo reprehenderit optio amet ab temporibus asperiores quasi cupiditate. Voluptatum ducimus voluptates voluptas');
					$legales = array('(1) Válido en operaciones de contado y financiamiento para todos los paquetes de Chevrolet Beat<sup>&reg;</sup> 2018. (2) Tasa de 0.0% de interés a un plazo de 18 meses, con 35% de enganche, aplica para todos los paquetes de Chevrolet Beat<sup>&reg;</sup> 2018. CAT sin IVA del 12.4% calculado para Chevrolet Beat<sup>&reg;</sup> LS 2017. Aplica en operaciones financiadas con GM Financial. (3) Mensualidad válida para Chevrolet Beat<sup>&reg;</sup> LS 2018. Aplica en operaciones financiadas con GM Financial de México, S.A. de C.V., SOFOM, E.R. con una tasa de 12.08% de interés, 2.5% de comisión por apertura en un plazo de 72 meses, con 35% de enganche y 6 pagos anuales extraordinarios de $11,022.25 respectivamente, durante el periodo que dura el financiamiento a pagar en los meses de diciembre. CAT de 43.1% respectivamente para fines informativos y de comparación. (4) Incluye un año de seguro de cobertura amplia con ABA Seguros en operaciones de contado o financiamiento para todos los paquetes de Chevrolet Beat<sup>&reg;</sup>. Estos CAT son calculados al 13 de junio de 2017 para fines informativos y de comparación, considerando el primer año del seguro del vehículo y la comisión por apertura como pagados de contado y el resto del plazo considerando el seguro del vehículo financiado calculado con prima promedio.  Vigencia del 4 al 31 de julio de 2017.Ninguna de estas ofertas aplica con otras promociones ni en la compra de vehículos flotilla. Para mayor información sobre los planes de financiamiento, requisitos de contratación y comisiones con GM Financial de México, S.A. de C.V., SOFOM, E.R. (GM Financial), consulte www.gmfinancial.mx. No incluye seguro de vida, ni de desempleo. Las cantidades expresadas son en moneda nacional, incluyen IVA e ISAN. Consulta modalidades, términos y condiciones en chevrolet.mx o con tu Distribuidor Autorizado Chevrolet. Las fotografías que aparecen son de uso ilustrativo. Las marcas Chevrolet<sup>&reg;</sup> y Chevrolet Beat<sup>&reg;</sup> así como sus respectivos logotipos y avisos comerciales son propiedad de General Motors, LLC. y General Motors de México, S. de R.L. de C.V. es su licenciataria autorizada en los Estados Unidos Mexicanos.' );
	    			return view('descarga/bono')
			    		->with('campana', $campana)
			    		->with('imagenes', $imagenes)
			    		->with('titulo', $titulo)
			    		->with('description', $description)
			    		->with('legales', $legales);
	    			break;
	    		
	    		default:
	    			
	    			break;
	    	}
    	}else{
    	$campana = array('0');
		$imagenes = array(1 => 'default_uno.png', 2 => 'default_dos.png' );
		$titulo = array(1 => 'BONO DE LEALTAD DEFAULT');
		$description = array(1 => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi non quis exercitationem culpa nesciunt nihil aut nostrum explicabo reprehenderit optio amet ab temporibus asperiores quasi cupiditate. Voluptatum ducimus voluptates voluptas');
		$legales = array('(1) Válido en operaciones de contado y financiamiento para todos los paquetes de Chevrolet Beat<sup>&reg;</sup> 2018. (2) Tasa de 0.0% de interés a un plazo de 18 meses, con 35% de enganche, aplica para todos los paquetes de Chevrolet Beat<sup>&reg;</sup> 2018. CAT sin IVA del 12.4% calculado para Chevrolet Beat<sup>&reg;</sup> LS 2017. Aplica en operaciones financiadas con GM Financial. (3) Mensualidad válida para Chevrolet Beat<sup>&reg;</sup> LS 2018. Aplica en operaciones financiadas con GM Financial de México, S.A. de C.V., SOFOM, E.R. con una tasa de 12.08% de interés, 2.5% de comisión por apertura en un plazo de 72 meses, con 35% de enganche y 6 pagos anuales extraordinarios de $11,022.25 respectivamente, durante el periodo que dura el financiamiento a pagar en los meses de diciembre. CAT de 43.1% respectivamente para fines informativos y de comparación. (4) Incluye un año de seguro de cobertura amplia con ABA Seguros en operaciones de contado o financiamiento para todos los paquetes de Chevrolet Beat<sup>&reg;</sup>. Estos CAT son calculados al 13 de junio de 2017 para fines informativos y de comparación, considerando el primer año del seguro del vehículo y la comisión por apertura como pagados de contado y el resto del plazo considerando el seguro del vehículo financiado calculado con prima promedio.  Vigencia del 4 al 31 de julio de 2017.Ninguna de estas ofertas aplica con otras promociones ni en la compra de vehículos flotilla. Para mayor información sobre los planes de financiamiento, requisitos de contratación y comisiones con GM Financial de México, S.A. de C.V., SOFOM, E.R. (GM Financial), consulte www.gmfinancial.mx. No incluye seguro de vida, ni de desempleo. Las cantidades expresadas son en moneda nacional, incluyen IVA e ISAN. Consulta modalidades, términos y condiciones en chevrolet.mx o con tu Distribuidor Autorizado Chevrolet. Las fotografías que aparecen son de uso ilustrativo. Las marcas Chevrolet<sup>&reg;</sup> y Chevrolet Beat<sup>&reg;</sup> así como sus respectivos logotipos y avisos comerciales son propiedad de General Motors, LLC. y General Motors de México, S. de R.L. de C.V. es su licenciataria autorizada en los Estados Unidos Mexicanos.' );
    	return view('descarga/bono')
	    		->with('campana', $campana)
	    		->with('imagenes', $imagenes)
	    		->with('titulo', $titulo)
	    		->with('description', $description)
	    		->with('legales', $legales);
	    }
    }

    public function descarga_bono(){
    	echo 'entro';
    }
}
