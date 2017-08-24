<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vin extends Model
{
    //
    protected $fillable = [
        'vin', 'id_campana', 'flag_folio', 'email'
    ];
}
