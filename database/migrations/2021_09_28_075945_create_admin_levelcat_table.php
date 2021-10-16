<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminLevelcatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_levelcat', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 128);
            $table->string('style', 128)->nullable();
            $table->string('image', 300);
            $table->integer('sort');
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
        Schema::dropIfExists('admin_levelcat');
    }
}
