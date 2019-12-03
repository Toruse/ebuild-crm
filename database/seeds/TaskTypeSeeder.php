<?php

use Illuminate\Database\Seeder;

class TaskTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
}
