<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create Administrator user with factory
        factory(User::class)->create([
            'name' => 'CRM Administrator',
            'email' => 'admin@site.com',
            'role' => 'Administrator'
        ]);

        // create Manager user with factory
        factory(User::class)->create([
            'name' => 'CRM Manager',
            'email' => 'manager@site.com',
            'role' => 'Manager'
        ]);
    }
}
