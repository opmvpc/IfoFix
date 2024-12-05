<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DevicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $devices = [
            ['name' => 'iPhone 13', 'brandId' => 1, 'typeId' => 1],
            ['name' => 'Galaxy S21', 'brandId' => 2, 'typeId' => 1],
            ['name' => 'iPad Pro', 'brandId' => 1, 'typeId' => 2],
            ['name' => 'Galaxy Tab S7', 'brandId' => 2, 'typeId' => 2],
            ['name' => 'HP Pavillon', 'brandId' => 3, 'typeId' => 3],
            ['name' => 'Asus Zenbook', 'brandId' => 4, 'typeId' => 3],
            ['name' => 'Acer Nitro', 'brandId' => 5, 'typeId' => 3],
        ];

        foreach ($devices as $device) {
            \App\Models\Device::create($device);
        }
    }
}
