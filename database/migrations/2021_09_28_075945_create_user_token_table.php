<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTokenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_token', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id');
            $table->unsignedTinyInteger('user_type')->default('1')->comment('1-> user(member); 2-> service provider');
            $table->string('issued_in', 30);
            $table->string('expires_in', 30);
            $table->string('token_access', 256);
            $table->string('status', 1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_token');
    }
}
