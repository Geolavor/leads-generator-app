<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->text('title');
            $table->integer('has_items')->default(0);
            $table->integer('expected_items')->default(0);
            $table->json('location')->nullable();
            $table->integer('last_city_id')->default(0);
            $table->integer('status_id')->unsigned();
            $table->string('page_token')->nullable();
            $table->string('next_page_token')->nullable();
            $table->string('per_city')->nullable();
            $table->decimal('total_price')->default('0.00');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('search_locations');
    }
}
