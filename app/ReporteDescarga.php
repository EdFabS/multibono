<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReporteDescarga extends Model
{
    //
    protected $fillable = [
        'vin', 'folio', 'mail', 'descargas', 'fecha'
    ];
}
