<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMixerDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mixer_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('tstamp');
            $table->unsignedBigInteger('mixer_id');
            $table->foreign('mixer_id')->references('id')->on('mixers');
            $table->string('id_rawmate');
            $table->string('rawmate_name');
            $table->float('qty_target');
            $table->float('qty_actual');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mixer_details');

    }
}
