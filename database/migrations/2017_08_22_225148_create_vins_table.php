<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vin');
            $table->string('id_campana');
            $table->string('llave',32)->unique();
            $table->string('mail')->default(null);
            $table->boolean('flag_folio')->default(false);
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
        Schema::drop('vins');
    }
}
