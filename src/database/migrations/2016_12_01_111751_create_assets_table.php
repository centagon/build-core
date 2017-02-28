<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use DB;
use Build\Core\Eloquent\Models\Asset;

class CreateAssetsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('assets')) {

            $this->fresh();
        }
    }

    private function fresh()
    {

        Schema::create('assets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->unique();
            $table->string('filename');
            $table->string('filesize');
            $table->string('mimetype');
            $table->string('extension');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');
    }

}
