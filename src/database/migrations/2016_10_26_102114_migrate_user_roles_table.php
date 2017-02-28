<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrateUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('user_roles')) {
            $this->migrate();
        }
        
    }
    
    private function migrate() {
        Schema::table('user_roles', function (Blueprint $table) {
            $table->dropForeign('user_roles_role_id_foreign');
        });
        
        Schema::rename('user_roles', 'user_role');
        
        Schema::table('user_role', function (Blueprint $table) {
            $table->foreign('role_id')
                ->references('id')->on('roles')
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
        //
    }
}
