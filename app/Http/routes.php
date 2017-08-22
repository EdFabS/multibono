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

Route::get('/', function () {
    return view('welcome');
});

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