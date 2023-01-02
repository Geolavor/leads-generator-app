<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDnsToOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->string('domain_created')->nullable()->after('archive');
            $table->string('domain_expires')->nullable()->after('domain_created');
            $table->string('domain_owner')->nullable()->after('domain_expires');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->string('domain_created')->nullable()->after('archive');
            $table->string('domain_expires')->nullable()->after('domain_created');
            $table->string('domain_owner')->nullable()->after('domain_expires');
        });
    }
}
