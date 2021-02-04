<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableWbfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wbfile', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('datein')->nullable();
            $table->string('dateout')->nullable();
            $table->string('timein')->nullable();
            $table->string('timeout')->nullable();
            $table->string('ticket')->nullable();
            $table->string('wbcat')->nullable();
            $table->string('type')->nullable();
            $table->string('vehicle')->nullable();
            $table->string('gs')->nullable();
            $table->integer('gross')->nullable();
            $table->string('te')->nullable();
            $table->integer('tare')->nullable();
            $table->integer('nett')->nullable();
            $table->integer('pno')->nullable();
            $table->string('status')->nullable();
            $table->string('vehicleout')->nullable();
            $table->integer('kepalain')->nullable();
            $table->integer('kepalaout')->nullable();
            $table->string('inby')->nullable();
            $table->string('outby')->nullable();
            $table->string('flag')->nullable();
            $table->string('companyid')->nullable();
            $table->string('documentno')->nullable();
            $table->string('itemno')->nullable();
            $table->string('statusax')->nullable();
            $table->string('inventtransid')->nullable();
            $table->string('pickingroute')->nullable();
            $table->bigInteger('recid')->nullable();
            $table->string('site')->nullable();
            $table->string('wbid')->nullable();
            $table->string('barcode')->nullable();
            $table->string('remark')->nullable();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wbfile');
    }
}
