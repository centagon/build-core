<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrateAssetsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('assets')) {

            // Do we need to migrate old files ??
            if (Schema::hasTable('media_files')) {
                $this->migrate();
            }
        }
    }

    private function migrate()
    {

        Schema::create('assets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->unique();
            $table->string('filename');
            $table->string('migrated_path');
            $table->string('filesize');
            $table->string('mimetype');
            $table->string('extension');
            $table->timestamps();
        });

        $files = DB::table('media_files')
            ->join('media_directories', 'media_files.directory_id', '=', 'media_directories.id')
            ->select('media_files.*, media_directories.path')
            ->get();

        // Loop through all the files and create assets for each one
        foreach ($files as $file) {
            $asset = Asset::create((array) $file);

            $asset->migrated_path = $file->path;

            if (strpos('.', $file->filename) >= 0) {
                $extension = array_last(explode('.', $file->filename));
            } else {
                $extension = '';
            }

            $asset->extension = $extension;
            $asset->save();

            $old_path = public_path('media' . $file->path . '/' . $file->filename);
            if (!is_file($old_path)) {
                $old_path = storage_path('media' . $file->path . '/' . $file->filename);
            }

            if (!is_file($old_path)) {
                continue;
            }

            try {
                copy($old_path, $asset->path);
                $asset->generatePreview();
            } catch (\Exception $e) {
                //
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }

}
