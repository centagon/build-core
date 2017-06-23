<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDashboardBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dashboard_blocks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('website_id');
            $table->string('title');
            $table->string('color');
            $table->integer('width');
            $table->integer('height');
            $table->integer('x');
            $table->integer('y');
            $table->text('content');
            $table->string('image');
            $table->string('button_label');
            $table->string('button_url');
            $table->timestamps();

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
        Schema::dropIfExists('dashboard_blocks');
    }
}
