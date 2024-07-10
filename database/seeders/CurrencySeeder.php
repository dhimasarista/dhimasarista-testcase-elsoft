<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
    }
}
