<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Hack core: Change the migration
 * Added by AuTN
 */
class UpdateCmsBlogTranslationsTableFieldHtmlContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cms_blog_translations', function (Blueprint $table) {
            $table->longtext('html_content')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cms_blog_translations', function (Blueprint $table) {
            $table->text('html_content')->nullable()->change();
        });
    }
}
