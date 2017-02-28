<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguageEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('language_entries')) {
            return;
        }
        
        Schema::create('language_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('language_id')->unsigned();
            $table->integer('dictionary_id')->unsigned();
            $table->string('locale');
            $table->string('entry');
            $table->text('value');
            $table->timestamps();

            $table->foreign('language_id')
                ->references('id')->on('languages')
                ->onDelete('cascade');

            $table->foreign('dictionary_id')
                ->references('id')->on('language_dictionaries')
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
        Schema::dropIfExists('language_entries');
    }
}
