<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IndexFolioInVfcTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('vins_folio_campanas', function ($table) {
            $table->unique('folio'); // Drops index 'geo_state_index'
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
        Schema::table('vins_folio_campanas', function ($table) {
            $table->dropUnique('vins_folio_campanas_folio_unique'); // Drops index 'geo_state_index'
        });
    }
}
