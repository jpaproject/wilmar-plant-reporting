<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiloAdjustmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('silo_adjustments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('jurnal');
            $table->string('type');
            $table->datetime('date');
            $table->string('item_number');
            $table->string('warehouse');
            $table->string('location');
            $table->float('quantity');
            $table->string('file_name');
            $table->string('silo');
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
        Schema::dropIfExists('silo_adjustments');
    }
}
