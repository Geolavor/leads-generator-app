<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title');
            $table->string('rating');
            $table->string('types');

            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->string('street');
            $table->string('street_number');
            $table->string('postal_code');
            $table->json('address')->nullable();
            
            $table->string('icon');

            $table->string('formatted_address');
            $table->string('user_ratings_total');
            $table->string('place_id')->nullable()->unique();
            $table->string('lat');
            $table->string('lng');
            
            $table->string('website');
            $table->string('formatted_phone_number');
            $table->string('international_phone_number');
            $table->string('business_status');

            $table->string('keywords');
            $table->string('description');

            $table->boolean('is_ecommerce')->default(0);
            
            $table->string('in_black_list')->default(false);
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
        Schema::dropIfExists('organizations');
    }
}
