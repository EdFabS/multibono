<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class vins_controller extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function carga_vins(){
    	return view('vins/carga_vins');
    }
}
