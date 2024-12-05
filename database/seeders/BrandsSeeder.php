<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['name' => 'Apple'],
            ['name' => 'Samsung'],
            ['name' => 'Hp'],
            ['name' => 'Asus'],
            ['name' => 'Acer'],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
