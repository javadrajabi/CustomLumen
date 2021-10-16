<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedTinyInteger('receive_type')->default('1')->comment('1-> hame(mamulan modiriyat mifreste), 2-> hameye member va sp ha, 3-> hameye memberha, 4-> hameye sp ha');
            $table->string('title', 128)->nullable();
            $table->text('description');
            $table->integer('sp_id')->index('sp_id')->comment('0 = admin');
            $table->string('send_time', 20);
            $table->unsignedTinyInteger('send_sms')->default('0');
            $table->unsignedTinyInteger('status')->default('1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announcements');
    }
}
