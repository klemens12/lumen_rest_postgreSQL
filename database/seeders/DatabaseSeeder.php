<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $users = [];
        $companies = [];
        $currentTime = Carbon::now();
        
        for ($i = 1; $i < 6; $i++) {
            $users[$i] = [
             
                'first_name' => 'First_name_test_' . Str::random(10),
                'last_name' => 'Last_name_test_' . Str::random(10),
                'email' =>  'testemail' . $i . '@test.com',
                'phone' => '+38000000000' . $i,
                'password' => app('hash')->make('123456'),
                'created_at' => $currentTime,
                'updated_at' => $currentTime
            ];
            
            $userInfo = $users[$i];
            
            $companies[$i] = [
               
                'title' => 'Company_name ' . $i,
                'phone' => '+38000201000' . $i,
                'description' => Str::random(255),
                'created_at' => $currentTime,
                'updated_at' => $currentTime
            ];

            User::insert($userInfo);
            $user = User::find($i);
            
            $companyInfo = $companies[$i];
            Company::insert($companyInfo);
            $lastInsertedCompany = Company::find($i);
            $user->companies()->attach($lastInsertedCompany->id);
        }
        
        $currentTime = Carbon::now();
        $company = [
            'title' => 'Company_name ' . $i,
            'phone' => '+38000201000' . $i,
            'description' => Str::random(255),
            'created_at' => $currentTime,
            'updated_at' => $currentTime
        ];
        $id = Company::insertGetId($company);

        $lastUserCollection = User::find(count($users)-1);
        $lastCompany = $lastUserCollection->companies()->get();
        $lastUserCollection->companies()->attach($id);
        
        $firstUserCollection = User::find(1);
        $firstUserCollection->companies()->attach($id);
    }

}
