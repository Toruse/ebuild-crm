<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDataInTaskTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('task_types')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('task_types')->insert([
            ['name' => 'Electrical'],
            ['name' => 'Plumbing'],
            ['name' => 'Tile'],
            ['name' => 'Stone'],
            ['name' => 'Painting'],
            ['name' => 'Cabinets'],
            ['name' => 'Stucco'],
            ['name' => 'Flooring'],
            ['name' => 'Shower Glass'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
