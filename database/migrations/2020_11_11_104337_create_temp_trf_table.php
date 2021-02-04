<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempTrfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_trf', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('job')->unique();
            $table->string('receiver_product_ident');
            $table->string('product_name');
            $table->float('qty');
            $table->string('start_date_actual');
            $table->string('end_date_actual');
            $table->bigInteger('sender_storage_ident_enumeration');
            $table->bigInteger('receiver_storage_ident_enumeration');
            $table->datetime('datetime');
            $table->string('type');
            $table->string('file_name');
            $table->string('sender');
            $table->string('receive');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_trf');
    }
}
