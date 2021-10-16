<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('level');
            $table->integer('portalid')->default(0);
            $table->string('name', 64);
            $table->string('image', 128)->nullable();
            $table->string('user', 32)->unique('user');
            $table->string('pass', 128);
            $table->string('lastlogin', 32)->nullable();
            $table->string('lastip', 15)->nullable();
            $table->integer('badlogin')->default(0);
            $table->string('badlogintime', 32)->nullable();
            $table->longText('levelaccess')->nullable();
            $table->string('mobile', 22)->nullable();
            $table->string('smssend', 1)->default('0');
            $table->string('status', 1)->default('1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin');
    }
}
