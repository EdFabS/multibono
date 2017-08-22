<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatedForeingKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('vin_folio_campana', function (Blueprint $table) {
            $table->foreign('id_vin')->references('id')->on('vins');
            $table->foreign('id_campana')->references('id')->on('campanas');
        });

        Schema::table('campanas', function (Blueprint $table) {
            $table->foreign('id_unidad')->references('id')->on('unidades_negocio');
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
    }
}
