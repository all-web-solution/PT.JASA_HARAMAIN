<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'full_name' => 'Admin Haramaini',
            'email' => 'admin@gmail.com',
            'password' => 'admin123',
            'phone' => '085777750854',
            'address' => 'Kp Tamansari',
            'role' => 'admin',
        ]);
    }
}
