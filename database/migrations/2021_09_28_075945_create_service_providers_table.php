<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_providers', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('parent_id')->nullable()->index('parent_id')->comment('agar record zirmajmueye yeki az recordhaye hamin table bud, in field por mishavad');
            $table->string('user', 32);
            $table->string('pass', 128);
            $table->string('name', 128);
            $table->unsignedTinyInteger('appointment_type')->default('2')->comment('1-> Niyaz be taeed, 2-> Automatic	');
            $table->string('ostan', 32)->default('11')->index('ostan');
            $table->string('shahrestan', 32)->default('1109')->index('shahrestan');
            $table->string('shift_sobh', 32)->nullable();
            $table->string('shift_asr', 32)->nullable();
            $table->string('shift_shab', 32)->nullable();
            $table->string('image', 100)->nullable();
            $table->string('scatids');
            $table->string('sids')->nullable();
            $table->string('mobile', 15)->nullable();
            $table->string('tell', 15)->nullable();
            $table->text('address')->nullable();
            $table->string('latitude', 32)->nullable();
            $table->string('longitude', 32)->nullable();
            $table->unsignedTinyInteger('plan_type')->nullable();
            $table->string('about_us_text', 512)->nullable();
            $table->string('invite_friends_text', 512)->nullable();
            $table->string('welcome_message', 512)->nullable();
            $table->string('app_name', 128)->nullable();
            $table->string('logo', 256)->nullable();
            $table->string('website', 512)->nullable();
            $table->string('telegram', 128)->nullable();
            $table->string('instagram', 128)->nullable();
            $table->text('description')->nullable();
            $table->string('setdate', 50);
            $table->integer('portalid')->nullable();
            $table->string('device_id', 64)->nullable()->comment('OneSignal PlayerID');
            $table->tinyInteger('receive_notifications')->default(1)->index('receive_notifications');
            $table->string('status', 1)->nullable();
            $table->string('temp', 128)->nullable();

            $table->index(['user', 'pass'], 'user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_providers');
    }
}
