<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicecatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicecat', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('code', 32)->unique('code');
            $table->string('pagename', 128)->nullable();
            $table->string('name', 64);
            $table->string('type', 1)->default('1');
            $table->integer('level')->default(0);
            $table->text('description')->nullable();
            $table->string('header', 128)->nullable();
            $table->string('image', 128)->nullable();
            $table->string('style', 300)->nullable();
            $table->string('keywords', 400)->nullable();
            $table->string('memtype', 1)->default('0');
            $table->integer('portalid')->default(0)->index('portalid');
            $table->string('showinmenu', 1)->default('1');
            $table->string('showinhome', 1)->default('1');
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
        Schema::dropIfExists('servicecat');
    }
}
