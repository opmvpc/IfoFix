<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'firstName' => 'seb',
            'lastName' => 'ivrogne',
            'email' => 'seb@gmail.com',
            'role' => 'admin',
            'password' => bcrypt('azerty1234')
        ]);
        User::factory()->create([
            'firstName' => 'hadri',
            'lastName' => 'ivrogne',
            'email' => 'hadri@example.com',
            'role' => 'admin',
            'password' => bcrypt('password')
        ]);
        User::factory()->create([
            'firstName' => 'bob',
            'lastName' => 'le bricoleur',
            'email' => 'bob@example.com',
            'role' => 'technician',
            'password' => bcrypt('password')
        ]);
    }
}
