<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempMixersDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_mixer_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('tstamp');
            $table->unsignedBigInteger('mixer_id');
            $table->foreign('mixer_id')->references('id')->on('temp_mixers');
            $table->string('id_rawmate');
            $table->string('rawmate_name');
            $table->float('qty_target');
            $table->float('qty_actual');
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->datetime('start_tstamp')->nullable();
            $table->datetime('end_tstamp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_mixer_details');
    }
}
