<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ItemUnit;
use App\Models\ItemAccountGroup;
use App\Models\ItemGroup;
use App\Models\ItemType;
use Illuminate\Support\Str;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
    }
}
