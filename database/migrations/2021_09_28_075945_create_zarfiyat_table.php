<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZarfiyatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zarfiyat', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sp_id')->index('dr_code');
            $table->string('service_id', 512);
            $table->unsignedTinyInteger('shift')->index('shift')->comment('1-> sobh, 2-> asr, 3-> shab');
            $table->string('set_date', 20);
            $table->string('date', 25)->index('date');
            $table->unsignedInteger('zarfiyat');
            $table->unsignedInteger('reserved')->default('0');
            $table->string('wait_time', 20)->nullable()->comment('minutes');
            $table->string('starttime', 20)->nullable();
            $table->string('endtime', 20)->nullable();
            $table->unsignedTinyInteger('status')->comment('1-> active, 99-> deleted by sp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zarfiyat');
    }
}
