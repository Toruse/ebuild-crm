<?php

use Illuminate\Database\Seeder;

class SourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sources')->insert([
            ['name' => 'Referral'],
            ['name' => 'Website'],
            ['name' => 'Yelp'],
            ['name' => 'Email'],
        ]);
    }
}
