<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOstanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ostan', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('code', 32)->unique('code');
            $table->string('countrycode', 2)->index('countrycode');
            $table->string('name', 128);
            $table->integer('sort');
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
        Schema::dropIfExists('ostan');
    }
}
