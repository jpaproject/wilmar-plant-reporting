<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTstampToMixers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mixers', function (Blueprint $table) {
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
        Schema::table('mixers', function (Blueprint $table) {
            $table->dropColumn('start_tstamp');
            $table->dropColumn('end_tstamp');
        });
    }
}
