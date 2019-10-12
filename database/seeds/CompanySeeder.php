<?php

use App\Company;
use App\Employee;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create companies with factory
        factory(Company::class, 10)->create()->each(function ($company) {

            //let's create 10 employees for each company
            for($i = 0; $i < 10; $i++) {
                $company->employees()->save(factory(Employee::class)->make());
            }
        });
    }
}
