<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            'Jakarta',
            'Surabaya',
            'Bandung',
            'Semarang',
            'Yogyakarta',
            'Bali',
        ];

        foreach ($cities as $city) {
            $cityData[] = [
                'name' => $city,
                'slug' => Str::slug($city, '-'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('cities')->insert($cityData);
    }
}
