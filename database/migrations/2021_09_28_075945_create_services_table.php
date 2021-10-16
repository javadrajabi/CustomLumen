<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('code', 32)->unique('code');
            $table->string('name', 128);
            $table->string('category', 32)->index('category');
            $table->string('keywords', 200)->nullable();
            $table->text('description')->nullable();
            $table->longText('fulldescription')->nullable();
            $table->integer('viewcount')->nullable()->default(0);
            $table->string('setdate', 20);
            $table->string('image', 128)->nullable();
            $table->string('linkcatalog', 300)->nullable();
            $table->string('linkvideo', 300)->nullable();
            $table->integer('gallerycat')->nullable();
            $table->integer('slideshowcat')->nullable()->index('slideshowcat');
            $table->integer('linkcat')->nullable()->index('r51');
            $table->integer('contentscat')->nullable()->index('r52');
            $table->integer('advertisecat')->nullable()->index('r53');
            $table->integer('pollingcat')->nullable()->index('r54');
            $table->integer('productcat')->nullable()->index('r55');
            $table->integer('faqcat')->nullable()->index('faqcat');
            $table->integer('sort');
            $table->string('style', 300)->nullable();
            $table->integer('portalid')->index('portalid');
            $table->string('status', 1);

            $table->index(['gallerycat', 'linkcat', 'contentscat', 'advertisecat', 'pollingcat', 'productcat'], 'gallerycat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
