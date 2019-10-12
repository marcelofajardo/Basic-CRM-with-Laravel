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
        //use user seeder to create users
        $this->call(UserSeeder::class);

        //use company seeder to create company and employees
        $this->call(CompanySeeder::class);
    }
}
