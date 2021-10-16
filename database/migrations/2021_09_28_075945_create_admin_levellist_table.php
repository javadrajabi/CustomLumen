<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminLevellistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_levellist', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('cat')->index('cat');
            $table->string('name', 128);
            $table->string('path', 128);
            $table->string('page', 128);
            $table->integer('sort')->default(0);
            $table->string('icon', 128)->nullable();
            $table->text('description')->nullable();
            $table->string('extraparam', 200)->nullable();
            $table->string('showinmenu', 1)->nullable()->default('0');
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
        Schema::dropIfExists('admin_levellist');
    }
}
