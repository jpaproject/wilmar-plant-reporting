<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiloAlarmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('silo_alarms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('storage_code');
            $table->date('date');
            $table->float('range_min', 11,2);
            $table->float('range_max', 11,2);
            $table->string('formula');
            $table->string('text');
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
        Schema::dropIfExists('silo_alarms');
    }
}
