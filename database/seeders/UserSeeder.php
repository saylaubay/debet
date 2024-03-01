<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
           "first_name"=>"Saylaubay",
           "last_name"=>"Bekmurzaev",
           "username"=>"sadmin",
           "email"=>"saylaww@gmail.com",
           "password"=>Hash::make("123"),
            "phone"=>"+998974748061",
            "company_id"=>1,
            "role_id"=>1,
        ]);
        User::create([
           "first_name"=>"Bil",
           "last_name"=>"Gates",
           "username"=>"admin",
           "email"=>"bill@gmail.com",
           "password"=>Hash::make("456"),
            "phone"=>"+998977777777",
            "company_id"=>1,
            "role_id"=>2,
        ]);
        User::create([
           "first_name"=>"Pavel",
           "last_name"=>"Durov",
           "username"=>"user",
           "email"=>"pavel@gmail.com",
           "password"=>Hash::make("789"),
            "phone"=>"+7854623154",
            "company_id"=>1,
            "role_id"=>3,
        ]);
    }
}
