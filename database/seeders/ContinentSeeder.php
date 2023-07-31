<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Continent;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContinentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Continent::insert(
            [
                [
                    'id' => 1,
                    'continent_name' => 'Africa'
                ],
                [
                    'id' => 2,
                    'continent_name' => 'Asia'
                ],
                [
                    'id' => 3,
                    'continent_name' => 'Australia'
                ],
                [
                    'id' => 4,
                    'continent_name' => 'Antarctica'
                ],
                [
                    'id' => 5,
                    'continent_name' => 'North America'
                ],
                [
                    'id' => 6,
                    'continent_name' => 'South America'
                ],
                [
                    'id' => 7,
                    'continent_name' => 'Europe'
                ],
            ]
        );
    }
}