<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempFeedmillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_feedmills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ticket')->nullable()->unique();
            $table->string('itemno')->nullable();
            $table->string('datein')->nullable();
            $table->string('dateout')->nullable();
            $table->string('timein')->nullable();
            $table->string('timeout')->nullable();
            $table->integer('nett')->nullable();
            $table->integer('jumlah_bag')->nullable();
            $table->integer('potongan')->nullable();
            $table->integer('nett_potong')->nullable();
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
        Schema::dropIfExists('temp_feedmills');
    }
}
