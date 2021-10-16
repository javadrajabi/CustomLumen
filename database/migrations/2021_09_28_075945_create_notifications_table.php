<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('sender')->index('sender');
            $table->integer('receiver')->index('receiver');
            $table->tinyInteger('sender_type')->comment('1->member, 2-> SP, 3->admin');
            $table->tinyInteger('receiver_type')->comment('1->member, 2-> SP, 3->admin	');
            $table->string('subject')->nullable();
            $table->mediumText('details')->nullable();
            $table->boolean('is_read')->nullable()->default(false);
            $table->boolean('status');
            $table->string('created_at', 20);
            $table->string('updated_at', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
