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
        $this->call(PositionSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(EmployeeHeadSeeder::class);
        $this->call(AdminSeeder::class);
    }
}
