<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        Company::create([
           "name"=>"Nukuslab",
        ]);
        Company::create([
           "name"=>"Bazar",
        ]);

        Company::factory()->count(20)->create();

    }
}
