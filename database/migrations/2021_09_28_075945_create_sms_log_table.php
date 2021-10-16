<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sp_id')->index('sp_id');
            $table->integer('member_id')->index('member_id');
            $table->string('send_time', 20);
            $table->string('text', 512);
            $table->unsignedTinyInteger('status')->comment('0: unknown, 1: sent, 2:not sent');
            $table->unsignedInteger('sms_panel_id')->default('1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_log');
    }
}
