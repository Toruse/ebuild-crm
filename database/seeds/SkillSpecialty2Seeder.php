<?php

use Illuminate\Database\Seeder;

class SkillSpecialty2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('user_skill_specialtys')->truncate();
        DB::table('skill_specialtys')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('skill_specialtys')->insert([
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
