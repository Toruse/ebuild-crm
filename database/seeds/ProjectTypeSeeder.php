<?php

use Illuminate\Database\Seeder;

class ProjectTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('project_types')->insert([
            ['name' => 'Kitchen Remodel'],
            ['name' => 'Bathroom Remodel'],
            ['name' => 'Kitchen and Bathroom Remodel'],
            ['name' => 'Addition'],
        ]);
    }
}
