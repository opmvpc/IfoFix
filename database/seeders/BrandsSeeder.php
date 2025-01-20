<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandsSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'Apple',
            'Samsung',
            'HP',
            'Asus',
            'Acer',
            'Lenovo',
            'Dell',
            'Microsoft',
            'Google',
            'OnePlus',
            'Xiaomi'
        ];

        foreach ($brands as $brand) {
            Brand::create(['name' => $brand]);
        }
    }
}
