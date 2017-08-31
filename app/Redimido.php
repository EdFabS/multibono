<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Redimido extends Model
{
    //
    protected $fillable = [
        'id_folio', 'fullname', 'parentesco', 'id_distribuidor', 'vendedor'
    ];
}
