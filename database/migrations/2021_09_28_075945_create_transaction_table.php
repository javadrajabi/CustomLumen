<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->integer('id', true)->index('userid');
            $table->string('price', 32);
            $table->string('type', 1)->comment('1->sharzh,2->baedasht,3->porsant');
            $table->string('description', 128);
            $table->string('userid', 32);
            $table->string('paymentid', 32)->nullable();
            $table->string('orderid', 32)->nullable();
            $table->string('createdate', 20);
            $table->string('updatedate', 20);
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
        Schema::dropIfExists('transaction');
    }
}
