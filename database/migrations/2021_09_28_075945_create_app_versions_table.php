<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_versions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 64)->nullable();
            $table->unsignedTinyInteger('app_type')->default('1')->comment('1-> user; 2-> service provider');
            $table->string('version', 16)->index('version');
            $table->boolean('mandatory')->default(false);
            $table->string('download_src', 64);
            $table->string('created_at', 25);
            $table->string('modified_at', 25);
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('status')->index('status');

            $table->index(['app_type', 'version', 'status'], 'app_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_versions');
    }
}
