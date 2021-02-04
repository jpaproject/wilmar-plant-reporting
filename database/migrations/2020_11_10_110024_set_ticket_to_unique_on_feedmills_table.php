<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetTicketToUniqueOnFeedmillsTable extends Migration
{

    // php artisan migrate:set_slug_to_unique_on_categories_table

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feedmills', function (Blueprint $table) {
            $table->unique('ticket');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feedmills', function (Blueprint $table) {
            $table->dropUnique('ticket');

        });
    }
}
