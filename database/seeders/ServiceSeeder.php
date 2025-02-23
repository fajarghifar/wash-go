<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Gold Wash',
                'price' => 180000, // 180k IDR
                'about' => 'Premium exterior wash for a sparkling finish.',
                'duration_in_hour' => 1,
            ],
            [
                'name' => 'Fix Paints',
                'price' => 2500000, // 2,500k IDR
                'about' => 'Professional paint correction and touch-up.',
                'duration_in_hour' => 3,
            ],
            [
                'name' => 'Interiors',
                'price' => 750000, // 750k IDR
                'about' => 'Deep cleaning of car interior, including seats and carpets.',
                'duration_in_hour' => 2,
            ],
            [
                'name' => 'Exteriors',
                'price' => 750000, // 750k IDR
                'about' => 'Detailed exterior cleaning with waxing.',
                'duration_in_hour' => 2,
            ],
            [
                'name' => '3D Coating',
                'price' => 1250000, // 1,250k IDR
                'about' => 'Advanced 3D ceramic coating for long-term protection.',
                'duration_in_hour' => 3,
            ],
            [
                'name' => 'Kaca Film',
                'price' => 7500000, // 7,500k IDR
                'about' => 'High-quality window tinting for heat and UV protection.',
                'duration_in_hour' => 30,
            ],
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(
                ['name' => $service['name']],
                [
                    'slug' => Str::slug($service['name'], '-'),
                    'price' => $service['price'],
                    'about' => $service['about'],
                    'duration_in_hour' => $service['duration_in_hour'],
                ]
            );
        }
    }
}
