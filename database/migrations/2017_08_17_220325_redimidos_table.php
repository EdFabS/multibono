<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RedimidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('redimidos', function($table){
            $table->increments('id');
            $table->integer('id_dealer');
            $table->integer('id_vfc');
            $table->string('full_name');
            $table->string('relationship');
            $table->string('salesman');
            $table->timestamps();
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
        Schema::drop('redimidos');
    }
}
