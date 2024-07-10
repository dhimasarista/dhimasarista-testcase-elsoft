<?php

namespace Database\Seeders;
use App\Models\Company;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $uuidCompany = Str::uuid()->toString();
        Company::create([
            "id" => $uuidCompany,
            "name" => "Test Case",
        ]);

        User::create([
            'name' => 'Test Case',
            'username' => "testcase",
            "password" => "testcase123",
            "company_id" => $uuidCompany,
        ]);
    }
}
