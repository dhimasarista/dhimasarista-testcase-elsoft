<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Company;
use App\Models\Currency;
use App\Models\ItemAccountGroup;
use App\Models\ItemGroup;
use App\Models\ItemType;
use App\Models\ItemUnit;
use App\Models\Status;
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
        Account::insert([
            [
                "id" => Str::uuid()->toString(),
                "name" => "Biaya Adm Bank - 800-01 - 800-01",
                "company_id" => $uuidCompany
            ],
            [
                "id" => Str::uuid()->toString(),
                "name" => "Ak. Penyusutan Gedung - 192-01 - 192-01",
                "company_id" => $uuidCompany
            ],
            [
                "id" => Str::uuid()->toString(),
                "name" => "Ak. Penyusutan Inventaris - 192-01 - 192-01",
                "company_id" => $uuidCompany
            ],
            [
                "id" => Str::uuid()->toString(),
                "name" => "Ak. Penyusutan Kendaraan - 192-01 - 192-01",
                "company_id" => $uuidCompany
            ],
        ]);
        Currency::insert(
            [
                'id' => Str::uuid()->toString(),
                'name' => "indonesia rupiah",
                'code' => "idr"
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => "singapore dollar",
                'code' => "sgd"
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => "united state dollar",
                'code' => "usd"
            ],
        );

        $itemGroupId1 = Str::uuid()->toString();
        $itemGroupId2 = Str::uuid()->toString();

        // Seed ItemType
        ItemType::create([
            'name' => 'Product',
        ]);

        // Seed ItemGroup
        ItemGroup::insert([
            [
                'id' => $itemGroupId1,
                'name' => 'Product - Lain-lain',
                'code' => 'prd',
            ],
            [
                'id' => $itemGroupId2,
                'name' => 'Service - Lain-lain',
                'code' => 'svc',
            ],
        ]);

        // Seed ItemAccountGroup
        ItemAccountGroup::insert([
            [
                'id' => Str::uuid()->toString(),
                'name' => 'Default',
                'item_groups_id' => $itemGroupId1,
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => 'Default',
                'item_groups_id' => $itemGroupId2,
            ],
        ]);

        // Seed ItemUnit
        ItemUnit::insert([
            [
                'id' => Str::uuid()->toString(),
                'name' => 'PCS',
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => 'Box',
            ],
        ]);

        Status::insert([
            [
                "id" => 1,
                "name" => "entry"
            ],
            [
                "id" => 2,
                "name" => "cancelled"
            ],
        ]);
    }
}
