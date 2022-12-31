<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlackListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('black_list', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('additional')->nullable();
            $table->string('token')->nullable();

            $table->integer('status_id')->unsigned();

            $table->boolean('delete_all')->default(0);
            $table->boolean('where_data_from')->default(0);
            $table->boolean('do_not_agree_entrusting_data')->default(0);

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
        Schema::dropIfExists('black_list');
    }
}
