<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempHpMillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_hp_mill', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('tstamp');
            $table->string('device');
            $table->float('tonnage');
            $table->float('kwh_sys');
            $table->float('kwh_motor');
            $table->float('current');
            $table->float('voltage');
            $table->float('current_motor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_hp_mill');
    }
}
