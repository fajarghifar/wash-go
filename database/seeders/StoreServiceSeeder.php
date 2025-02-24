<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StoreServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $storeServices = [];
        $stores = DB::table('stores')->pluck('id')->toArray();
        $services = DB::table('services')->pluck('id')->toArray();

        foreach ($stores as $storeId) {
            $assignedServices = array_rand($services, rand(4, count($services)));
            foreach ((array) $assignedServices as $serviceIndex) {
                $storeServices[] = [
                    'store_id' => $storeId,
                    'service_id' => $services[$serviceIndex],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('store_services')->insert($storeServices);
    }
}
