<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('sp_id')->index('mem_sp_cnst');
            $table->string('code', 32)->nullable();
            $table->string('fname', 32)->nullable();
            $table->string('lname', 32)->nullable();
            $table->string('gender', 1)->nullable()->default('0');
            $table->string('job', 128)->nullable();
            $table->integer('gradeid')->nullable()->index('gradeid');
            $table->string('father', 32)->nullable();
            $table->string('shsh', 12)->nullable();
            $table->string('birthloc', 32)->nullable();
            $table->string('birthday', 10)->nullable();
            $table->string('codemeli', 12)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('tel', 20)->nullable();
            $table->string('email', 128)->nullable();
            $table->string('image', 128)->nullable();
            $table->string('countrycode', 32)->nullable();
            $table->string('ostancode', 32)->nullable();
            $table->string('shahrestancode', 32)->nullable();
            $table->string('address', 200)->nullable();
            $table->string('codeposti', 20)->nullable();
            $table->string('activationcode', 128)->nullable();
            $table->integer('activationdate')->nullable();
            $table->integer('activationsendcount')->nullable();
            $table->integer('activationsendtime')->nullable();
            $table->string('moaref', 20)->nullable();
            $table->integer('secquestionid')->nullable();
            $table->string('secresponse', 128)->nullable();
            $table->integer('portalid')->index('portalid');
            $table->string('device_id', 64)->nullable()->comment('OneSignal PlayerID');
            $table->tinyInteger('receive_notifications')->default(1)->index('receive_notifications');
            $table->string('regdate', 20);
            $table->string('status', 2);
            $table->string('temp', 128)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
