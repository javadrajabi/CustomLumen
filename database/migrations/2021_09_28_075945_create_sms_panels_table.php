<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsPanelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_panels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('website', 128);
            $table->string('number', 32);
            $table->string('username', 32);
            $table->string('password', 256);
            $table->unsignedTinyInteger('status')->comment('0: deactivated, 1: active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_panels');
    }
}
