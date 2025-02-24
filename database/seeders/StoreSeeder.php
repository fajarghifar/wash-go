<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stores = [
            [
                'name' => 'Jakarta Auto Care',
                'city_id' => 1,
                'thumbnail' => 'stores/jakarta_auto_care.jpg',
                'is_open' => true,
                'is_full' => false,
                'address' => 'Jl. Sudirman No. 1, Jakarta',
                'phone_number' => '021-12345678',
                'cs_name' => 'Andi',
            ],
            [
                'name' => 'Surabaya Car Spa',
                'city_id' => 2,
                'thumbnail' => 'stores/surabaya_car_spa.jpg',
                'is_open' => true,
                'is_full' => false,
                'address' => 'Jl. Pemuda No. 10, Surabaya',
                'phone_number' => '031-87654321',
                'cs_name' => 'Budi',
            ],
            [
                'name' => 'Bandung Auto Detail',
                'city_id' => 3,
                'thumbnail' => 'stores/bandung_auto_detail.jpg',
                'is_open' => true,
                'is_full' => true,
                'address' => 'Jl. Merdeka No. 5, Bandung',
                'phone_number' => '022-99887766',
                'cs_name' => 'Citra',
            ],
            [
                'name' => 'Semarang Shine Car',
                'city_id' => 4,
                'thumbnail' => 'stores/semarang_shine_car.jpg',
                'is_open' => false,
                'is_full' => false,
                'address' => 'Jl. Pahlawan No. 3, Semarang',
                'phone_number' => '024-88776655',
                'cs_name' => 'Dedi',
            ],
            [
                'name' => 'Yogyakarta Car Wash',
                'city_id' => 5,
                'thumbnail' => 'stores/yogyakarta_car_wash.jpg',
                'is_open' => true,
                'is_full' => false,
                'address' => 'Jl. Malioboro No. 7, Yogyakarta',
                'phone_number' => '0274-77665544',
                'cs_name' => 'Eka',
            ],
            [
                'name' => 'Bali Luxury Auto',
                'city_id' => 6,
                'thumbnail' => 'stores/bali_luxury_auto.jpg',
                'is_open' => true,
                'is_full' => true,
                'address' => 'Jl. Sunset Road No. 99, Bali',
                'phone_number' => '0361-44556677',
                'cs_name' => 'Fajar',
            ],
        ];

        foreach ($stores as $store) {
            Store::create([
                'name' => $store['name'],
                'slug' => Str::slug($store['name'], '-'),
                'thumbnail' => $store['thumbnail'],
                'is_open' => $store['is_open'],
                'is_full' => $store['is_full'],
                'address' => $store['address'],
                'phone_number' => $store['phone_number'],
                'cs_name' => $store['cs_name'],
                'city_id' => $store['city_id'],
            ]);
        }
    }
}
