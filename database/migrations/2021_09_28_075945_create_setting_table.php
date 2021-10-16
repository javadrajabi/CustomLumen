<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 200);
            $table->string('domain', 200)->nullable();
            $table->string('createdate', 20)->nullable();
            $table->string('country', 32)->nullable();
            $table->string('ostan', 32)->nullable();
            $table->string('shahrestan', 32)->nullable();
            $table->string('bakhsh', 32)->nullable();
            $table->string('shahr', 32)->nullable();
            $table->string('abadi', 32)->nullable();
            $table->string('status', 1)->default('1');
            $table->string('title', 200)->nullable();
            $table->string('author', 200)->nullable();
            $table->string('copyright', 200)->nullable();
            $table->string('keywords', 200)->nullable();
            $table->string('description', 200)->nullable();
            $table->string('script', 400)->nullable();
            $table->string('enamad', 400)->nullable();
            $table->string('samandehi', 400)->nullable();
            $table->string('contact', 400)->nullable();
            $table->string('tel', 64)->nullable();
            $table->string('fax', 64)->nullable();
            $table->string('email', 128)->nullable();
            $table->string('googlemap', 350)->nullable();
            $table->string('googleplus', 200)->nullable();
            $table->string('instagram', 200)->nullable();
            $table->string('facebook', 200)->nullable();
            $table->string('twitter', 200)->nullable();
            $table->string('linkedin', 200)->nullable();
            $table->string('skype', 200)->nullable();
            $table->string('telegram', 200)->nullable();
            $table->string('aparat', 200)->nullable();
            $table->string('youtube', 200)->nullable();
            $table->string('contacttitle', 200)->nullable();
            $table->longText('contacttext')->nullable();
            $table->string('abouttitle', 200)->nullable();
            $table->string('rss', 128)->nullable();
            $table->string('favicon', 200)->nullable();
            $table->string('logo', 200)->nullable();
            $table->string('logo2', 200)->nullable();
            $table->string('loginattempts', 16)->nullable();
            $table->string('banduration', 16)->nullable()->comment('min');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting');
    }
}
