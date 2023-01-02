<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAllItemsToSearchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('search_locations', function (Blueprint $table) {
            $table->integer('all_items')->default(0)->after('expected_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('search_locations', function (Blueprint $table) {
            $table->integer('all_items')->default(0)->after('expected_items');
        });
    }
}
