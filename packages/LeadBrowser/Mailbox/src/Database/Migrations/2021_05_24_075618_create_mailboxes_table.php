<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailboxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailboxes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject')->nullable();
            $table->string('source');
            $table->string('user_type');
            $table->string('name')->nullable();
            $table->text('reply')->nullable();
            $table->boolean('is_read')->default(0);
            $table->json('folders')->nullable();
            $table->json('from')->nullable();
            $table->json('sender')->nullable();
            $table->json('reply_to')->nullable();
            $table->json('cc')->nullable();
            $table->json('bcc')->nullable();
            $table->string('unique_id')->nullable()->unique();
            $table->string('message_id')->unique();
            $table->json('reference_ids')->nullable();

            $table->integer('employee_id')->unsigned()->nullable();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set null');

            $table->integer('lead_id')->unsigned()->nullable();
            $table->foreign('lead_id')->references('id')->on('leads')->onDelete('set null');

            $table->timestamps();
        });

        Schema::table('mailboxes', function (Blueprint $table) {
            $table->integer('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('mailboxes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mailboxes');
    }
}
