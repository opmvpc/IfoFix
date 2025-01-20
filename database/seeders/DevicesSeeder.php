<?php

namespace Database\Seeders;

use App\Models\Device;
use App\Models\Brand;
use App\Models\Type;
use Database\Factories\DeviceFactory;
use Illuminate\Database\Seeder;

class DevicesSeeder extends Seeder
{
    public function run(): void
    {
        $devices =
            [
                // Apple Devices
                'iPhone 13' => ['brand' => 'Apple', 'type' => 'Smartphone'],
                'iPhone 14' => ['brand' => 'Apple', 'type' => 'Smartphone'],
                'iPhone 15' => ['brand' => 'Apple', 'type' => 'Smartphone'],
                'iPad Pro' => ['brand' => 'Apple', 'type' => 'Tablet'],
                'iPad Air' => ['brand' => 'Apple', 'type' => 'Tablet'],
                'MacBook Pro' => ['brand' => 'Apple', 'type' => 'Laptop'],
                'MacBook Air' => ['brand' => 'Apple', 'type' => 'Laptop'],
                'iMac' => ['brand' => 'Apple', 'type' => 'Desktop'],

                // Samsung Devices
                'Galaxy S21' => ['brand' => 'Samsung', 'type' => 'Smartphone'],
                'Galaxy S22' => ['brand' => 'Samsung', 'type' => 'Smartphone'],
                'Galaxy S23' => ['brand' => 'Samsung', 'type' => 'Smartphone'],
                'Galaxy Tab S7' => ['brand' => 'Samsung', 'type' => 'Tablet'],
                'Galaxy Tab S8' => ['brand' => 'Samsung', 'type' => 'Tablet'],
                'Galaxy Book' => ['brand' => 'Samsung', 'type' => 'Laptop'],

                // HP Devices
                'HP Pavilion' => ['brand' => 'HP', 'type' => 'Laptop'],
                'HP EliteBook' => ['brand' => 'HP', 'type' => 'Laptop'],
                'HP Envy' => ['brand' => 'HP', 'type' => 'Laptop'],
                'HP Spectre' => ['brand' => 'HP', 'type' => 'Laptop'],
                'HP Desktop' => ['brand' => 'HP', 'type' => 'Desktop'],

                // Asus Devices
                'Asus Zenbook' => ['brand' => 'Asus', 'type' => 'Laptop'],
                'Asus ROG' => ['brand' => 'Asus', 'type' => 'Desktop'],
                'Asus TUF' => ['brand' => 'Asus', 'type' => 'Laptop'],
                'Asus ProArt' => ['brand' => 'Asus', 'type' => 'Desktop'],

                // Acer Devices
                'Acer Nitro' => ['brand' => 'Acer', 'type' => 'Laptop'],
                'Acer Predator' => ['brand' => 'Acer', 'type' => 'Desktop'],
                'Acer Swift' => ['brand' => 'Acer', 'type' => 'Laptop'],
                'Acer Aspire' => ['brand' => 'Acer', 'type' => 'Laptop'],

                // Lenovo Devices
                'Lenovo ThinkPad' => ['brand' => 'Lenovo', 'type' => 'Laptop'],
                'Lenovo Legion' => ['brand' => 'Lenovo', 'type' => 'Laptop'],
                'Lenovo Yoga' => ['brand' => 'Lenovo', 'type' => 'Laptop'],
                'Lenovo IdeaPad' => ['brand' => 'Lenovo', 'type' => 'Laptop'],

                // Dell Devices
                'Dell XPS' => ['brand' => 'Dell', 'type' => 'Laptop'],
                'Dell Inspiron' => ['brand' => 'Dell', 'type' => 'Laptop'],
                'Dell Alienware' => ['brand' => 'Dell', 'type' => 'Desktop'],
                'Dell Precision' => ['brand' => 'Dell', 'type' => 'Desktop'],

                // Microsoft Devices
                'Surface Pro' => ['brand' => 'Microsoft', 'type' => 'Tablet'],
                'Surface Laptop' => ['brand' => 'Microsoft', 'type' => 'Laptop'],
                'Surface Book' => ['brand' => 'Microsoft', 'type' => 'Laptop'],

                // Google Devices
                'Pixel 7' => ['brand' => 'Google', 'type' => 'Smartphone'],
                'Pixel 8' => ['brand' => 'Google', 'type' => 'Smartphone'],
                'Pixel Tablet' => ['brand' => 'Google', 'type' => 'Tablet'],

                // OnePlus Devices
                'OnePlus 11' => ['brand' => 'OnePlus', 'type' => 'Smartphone'],
                'OnePlus Nord' => ['brand' => 'OnePlus', 'type' => 'Smartphone'],

                // Xiaomi Devices
                'Xiaomi 13' => ['brand' => 'Xiaomi', 'type' => 'Smartphone'],
                'Xiaomi Pad' => ['brand' => 'Xiaomi', 'type' => 'Tablet'],
                'RedmiBook' => ['brand' => 'Xiaomi', 'type' => 'Laptop'],
            ];

        foreach ($devices as $deviceName => $info) {
            $brand = Brand::where('name', $info['brand'])->first();
            $type = Type::where('name', $info['type'])->first();

            if ($brand && $type) {
                Device::create([
                    'name' => $deviceName,
                    'brandId' => $brand->id,
                    'typeId' => $type->id,
                ]);
            }
        }
    }
}
