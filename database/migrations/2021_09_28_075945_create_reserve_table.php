<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReserveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserve', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedTinyInteger('user_type')->default('1')->index('user_type')->comment('1->User | 2->Service Provider');
            $table->string('user_id', 32)->nullable()->index('user_id');
            $table->integer('zarfiyat_id')->index('zarfiyat_id');
            $table->string('code', 50);
            $table->string('time', 5)->comment('08:00');
            $table->string('selected_service_id', 512)->nullable();
            $table->unsignedTinyInteger('type')->default('1')->comment('1:mamoli');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('req_date', 30)->nullable();
            $table->string('confirm_date', 30)->nullable();
            $table->integer('transaction_id')->nullable()->index('transaction_id');
            $table->unsignedTinyInteger('attendance_status')->default('0')->comment('0: namoshakhas | 1: hozoor | 2:adam hozoor');
            $table->string('attendance_date', 30)->nullable();
            $table->unsignedTinyInteger('status')->index('status')->comment('0:available, 1:reserved ,2:disabled by sp, 3:rejected, 4: canceled by sp, 5: canceled by user, 6: awaiting confirmation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reserve');
    }
}
