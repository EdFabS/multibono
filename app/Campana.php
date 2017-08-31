<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campana extends Model
{
    //
    protected $fillable = [
        'campana', 'id_unidad', 'url_img_logo', 'url_img_head', 'titulo', 'descripcion', 'legales'
    ];
}
