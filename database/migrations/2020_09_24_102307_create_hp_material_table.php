<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHpMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hp_materials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('job');
            $table->string('receiver_product_ident');
            $table->string('product_name');
            $table->datetime('start_date_actual');
            $table->datetime('end_date_actual');
            $table->string('sender_storage_ident_enumeration')->nullable();
            $table->string('receiver_storage_ident_enumeration')->nullable();
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
        Schema::dropIfExists('hp_materials');
    }
}
