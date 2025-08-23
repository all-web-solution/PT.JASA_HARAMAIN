<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = [
            'admin',
            'hotel',
            'handling',
            'transportasi & tiket',
            'visa dan acara',
            'reyal',
            'palugada',
            'konten dan dokumentasi',
        ];

        foreach ($roles as $role) {
            User::create([
                'name'      => ucfirst($role),
                'full_name' => ucfirst($role) . ' Haramaini',
                'email'     => $role . '@gmail.com',
                'password'  => Hash::make('password123'), // default password
                'phone'     => '0857' . rand(100000000, 999999999),
                'address'   => 'Kp Tamansari',
                'role'      => $role,
            ]);
        }
    }
}
