<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppLoginLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_login_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('device', 64)->nullable()->index('device');
            $table->string('ip', 16);
            $table->unsignedTinyInteger('os')->nullable()->comment('1-> Android, 2-> iOS');
            $table->string('datetime', 25)->index('datetime');
            $table->boolean('successful')->index('successful');
            $table->unsignedSmallInteger('attempts');

            $table->index(['device', 'ip', 'datetime', 'successful'], 'device_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_login_log');
    }
}
