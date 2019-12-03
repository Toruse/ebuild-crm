<?php

use Illuminate\Database\Seeder;

class SkillSpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('skill_specialtys')->insert([
            ['name' => 'Air Conditioning'],
            ['name' => 'Cabinets'],
            ['name' => 'Countertops'],
            ['name' => 'Electrical '],
            ['name' => 'Flooring'],
            ['name' => 'Framing'],
            ['name' => 'General/Handyman'],
            ['name' => 'Glass/Mirrors'],
            ['name' => 'Hot Mop'],
            ['name' => 'Painting'],
            ['name' => 'Plumbing'],
            ['name' => 'Roofing '],
            ['name' => 'Tiling'],
            ['name' => 'Windows'],
            ['name' => 'Other'],
        ]);
    }
}
