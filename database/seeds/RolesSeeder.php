<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'admin'],
            ['name' => 'customer'],
            ['name' => 'vendor'],
            ['name' => 'contractor'],
            ['name' => 'project_manager'],            
        ]);
    }
}
