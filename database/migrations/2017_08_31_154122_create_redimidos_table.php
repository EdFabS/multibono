<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRedimidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redimidos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_folio');
            $table->text('fullname');
            $table->text('parentesco');
            $table->integer('id_distribuidor');
            $table->text('vendedor');
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
        Schema::drop('redimidos');
    }
}
