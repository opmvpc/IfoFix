<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypesSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'Smartphone',
            'Tablet',
            'Laptop',
            'Desktop',
        ];

        foreach ($types as $type) {
            Type::create(['name' => $type]);
        }
    }
}
