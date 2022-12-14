<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->string('year_founded');
            $table->integer('size_range')->default(0);
            $table->integer('current_employee_number')->default(0);
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
            $table->string('year_founded');
            $table->integer('size_range')->default(0);
            $table->integer('current_employee_number')->default(0);
        });
    }
}
