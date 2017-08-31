<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInCampanasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('campanas', function ($table){
            $table->string('url_img_logo');
            $table->string('url_img_head');
            $table->text('titulo');
            $table->text('descripcion');
            $table->text('legales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('campanas', function($table){
            $table->dropColumn(['url_img_logo', 'url_img_head', 'titulo', 'descripcion', 'legales']);
        });
    }
}
