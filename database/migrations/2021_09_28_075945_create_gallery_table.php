<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gallery', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('sp_id')->nullable()->index('sp_id');
            $table->string('type', 1)->default('1');
            $table->string('title', 128)->nullable();
            $table->string('pic', 128)->nullable();
            $table->text('description')->nullable();
            $table->integer('portalid')->default(0)->index('portalid');
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
        Schema::dropIfExists('gallery');
    }
}
