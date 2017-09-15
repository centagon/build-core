<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUniqueIndexToLanguageEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $model = new \Build\Core\Eloquent\Models\Language\Entry();
        $tableName = $model->getTable();
        
        // Delete entries that already have more then one entry
        /**
        DB::statement("delete FROM {$tableName}
            where {$tableName}.id in (
                select id from (
                    SELECT count(*) as counter, max(id) as id

                     FROM {$tableName}

                     group by language_id, dictionary_id

                     having counter > 1
                 ) as invalid_counters
             )");
         * */
        
        Schema::table('language_entries', function (Blueprint $table) {
           $table->unique(['language_id', 'dictionary_id'], 'language_entries_language_id_dictionary_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('language_entries', function (Blueprint $table) {
           $table->dropUnique('language_entries_language_id_dictionary_id_unique');
        });
    }
}
