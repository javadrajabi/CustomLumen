<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('sender_user_id')->index('message_sender_user_id');
            $table->integer('receiver_user_id')->index('message_receiver_user_id');
            $table->unsignedTinyInteger('sender_type')->comment('1->member, 2-> SP, 3->admin');
            $table->unsignedTinyInteger('receiver_type')->comment('1->member, 2-> SP, 3->admin');
            $table->string('subject')->nullable();
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->string('created_at', 20);
            $table->string('updated_at', 20);
            $table->integer('parent_id')->index('parent_id')->comment('agar id = parent_id bashad, Yani avalin payam beyne in 2 nafar ast');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message');
    }
}
