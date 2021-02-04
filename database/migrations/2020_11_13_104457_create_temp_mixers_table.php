<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempMixersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_mixers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('tstamp');
            $table->string('job');
            $table->string('id_formula');
            $table->float('total_batch');
            $table->float('qty_target');
            $table->float('qty_actual');
            $table->string('product_ident');
            $table->string('start_date');
            $table->string('end_date');
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
        Schema::dropIfExists('temp_mixers');
    }
}
