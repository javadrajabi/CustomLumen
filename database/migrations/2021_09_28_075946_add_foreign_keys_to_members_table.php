<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->foreign(['sp_id'], 'mem_sp_cnst')->references(['id'])->on('service_providers')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign(['gradeid'], 'r16')->references(['id'])->on('grade')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['portalid'], 'r25')->references(['id'])->on('setting')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropForeign('mem_sp_cnst');
            $table->dropForeign('r16');
            $table->dropForeign('r25');
        });
    }
}
