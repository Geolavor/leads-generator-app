<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_blogs', function (Blueprint $table) {
            $table->id();
            $table->integer('topic_id')->unsigned();

            $table->integer('author_id')->nullable()->unsigned();
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->longtext('html_content')->nullable()->change();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('cms_blogs');
    }
}
