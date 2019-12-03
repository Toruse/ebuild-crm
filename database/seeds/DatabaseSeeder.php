<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(ProjectTypeSeeder::class);
        $this->call(SourcesSeeder::class);
        $this->call(SkillSpecialtySeeder::class);
        $this->call(SkillSpecialty2Seeder::class);
        $this->call(TaskTypeSeeder::class);
    }
}
