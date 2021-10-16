<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->foreign(['gallerycat'], 'r49')->references(['id'])->on('gallerycat')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['slideshowcat'], 'r50')->references(['id'])->on('slideshowcat')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['linkcat'], 'r51')->references(['id'])->on('linkcat')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['contentscat'], 'r52')->references(['id'])->on('category')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['advertisecat'], 'r53')->references(['id'])->on('advertisecat')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['pollingcat'], 'r54')->references(['id'])->on('pollingcat')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['productcat'], 'r55')->references(['id'])->on('productcat')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['faqcat'], 'r56')->references(['id'])->on('faqcat')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['portalid'], 'r57')->references(['id'])->on('setting')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign('r49');
            $table->dropForeign('r50');
            $table->dropForeign('r51');
            $table->dropForeign('r52');
            $table->dropForeign('r53');
            $table->dropForeign('r54');
            $table->dropForeign('r55');
            $table->dropForeign('r56');
            $table->dropForeign('r57');
        });
    }
}
