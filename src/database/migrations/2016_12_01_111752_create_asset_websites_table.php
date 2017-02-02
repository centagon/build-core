<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetWebsitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_websites', function (Blueprint $table) {
            $table->unsignedInteger('asset_id');
            $table->unsignedInteger('website_id');

            $table->foreign('asset_id')
                ->references('id')->on('assets')
                ->onDelete('cascade');

            $table->foreign('website_id')
                ->references('id')->on('websites')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_websites');
    }
}
