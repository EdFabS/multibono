<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/','Form_Descarga_Controller@descarga');

Route::auth();

Route::get('/home', 'HomeController@index');

//listar/crear unidades de negocios
Route::get('unidades', 'Unidades_Controller@unidades');
Route::post('crear_unidad', 'Unidades_Controller@crear_unidad');
//listar/crear modelos
Route::get('modelos', 'Modelo_Controller@modelos');
Route::post('crear_modelo', 'Modelo_Controller@crear_modelo');
//listar/crear campañas
Route::get('campanas', 'Campanas_Controller@campanas');
Route::post('crear_campana', 'Campanas_Controller@crear_campana');
//agregar vis
Route::get('vin', 'Vin_Controller@vin');
Route::post('addVin', 'Vin_Controller@addVin');
//agregar vins
Route::get('vins', 'Vins_Controller@vins');
Route::post('addVins', 'Vins_Controller@addVins');
//descarga de bono dependiendo la campaña
Route::get('descarga/','Form_Descarga_Controller@descarga');
Route::get('descarga/{campana}','Form_Descarga_Controller@descarga');
Route::post('descarga_bono','Descarga_Controller@descarga_bono');
//descarga por folio
Route::get('descarga_folio/{folio}','Descarga_Controller@descarga_folio');
//redimir folios
Route::get('folio', 'Folio_Controller@folio');
Route::get('folio/{campana}', 'Folio_Controller@folio');
Route::post('buscar_folio', 'Folio_Controller@buscar_folio');
Route::get('folio_form/{folio}', 'Redimir_Folio_Controller@folio_form');
Route::post('redimir', 'Redimir_Folio_Controller@redimir');