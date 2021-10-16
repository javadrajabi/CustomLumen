<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToShahrestanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shahrestan', function (Blueprint $table) {
            $table->foreign(['countrycode'], 'r11')->references(['code'])->on('country')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['ostancode'], 'r12')->references(['code'])->on('ostan')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shahrestan', function (Blueprint $table) {
            $table->dropForeign('r11');
            $table->dropForeign('r12');
        });
    }
}
