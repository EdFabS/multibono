<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewVinRedimidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_vin_redimidos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_folio');
            $table->string('new_vin');
            $table->integer('id_modelo');
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
        Schema::drop('new_vin_redimidos');
    }
}
