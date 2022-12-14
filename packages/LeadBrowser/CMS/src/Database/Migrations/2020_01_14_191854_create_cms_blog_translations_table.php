<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsBlogTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_blog_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('blog_title');
            $table->string('url_key');
            $table->text('html_content')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('locale');

            $table->integer('cms_blog_id')->unsigned();
            $table->unique(['cms_blog_id', 'url_key', 'locale']);
            // $table->foreign('cms_blog_id')->references('id')->on('cms_blogs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_blog_translations');
    }
}
