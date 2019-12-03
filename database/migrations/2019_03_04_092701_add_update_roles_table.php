<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUpdateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('roles')->insert([
            ['name' => 'sales_associate'],
        ]);

        DB::table('roles')
            ->where('name', 'customer')
            ->update(['name' => 'client']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('roles')
            ->where('name', 'client')
            ->update(['name' => 'customer']);

        DB::table('roles')
            ->where('name', 'sales_associate')
            ->delete();
    }
}
