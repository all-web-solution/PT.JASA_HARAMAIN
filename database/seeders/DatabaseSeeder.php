<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin admin',
                'full_name' => 'Admin Haramaini',
                'email' => 'admin@gmail.com',
                'phone' => '0857711485918',
                'address' => 'Kp Tamansari',
                'role' => 'admin',
            ],
            [
                'name' => 'Hotel hotel',
                'full_name' => 'Hotel Haramaini',
                'email' => 'hotel@gmail.com',
                'phone' => '0857297823295',
                'address' => 'Kp Tamansari',
                'role' => 'hotel',
            ],
            [
                'name' => 'Handling handling',
                'full_name' => 'Handling Haramaini',
                'email' => 'handling@gmail.com',
                'phone' => '0857965503750',
                'address' => 'Kp Tamansari',
                'role' => 'handling',
            ],
            [
                'name' => 'Transportasi & tiket handling',
                'full_name' => 'Transportasi & tiket Haramaini',
                'email' => 'tiket@gmail.com',
                'phone' => '0857697639543',
                'address' => 'Kp Tamansari',
                'role' => 'handling',
            ],
            [
                'name' => 'Visa dan acara visa dan acara',
                'full_name' => 'Visa dan acara Haramaini',
                'email' => 'visa@gmail.com',
                'phone' => '0857276101409',
                'address' => 'Kp Tamansari',
                'role' => 'visa dan acara',
            ],
            [
                'name' => 'Reyal reyal',
                'full_name' => 'Reyal Haramaini',
                'email' => 'reyal@gmail.com',
                'phone' => '0857319277062',
                'address' => 'Kp Tamansari',
                'role' => 'reyal',
            ],
            [
                'name' => 'Palugada palugada',
                'full_name' => 'Palugada Haramaini',
                'email' => 'palugada@gmail.com',
                'phone' => '0857560563355',
                'address' => 'Kp Tamansari',
                'role' => 'palugada',
            ],
            [
                'name' => 'Konten dan dokumentasi konten dan dokumentasi',
                'full_name' => 'Konten dan dokumentasi Haramaini',
                'email' => 'content@gmail.com',
                'phone' => '0857486516616',
                'address' => 'Kp Tamansari',
                'role' => 'konten dan dokumentasi',
            ],
        ];

        foreach ($users as $user) {
            User::create(array_merge($user, [
                'password' => Hash::make('password'),
            ]));
        }
    }
}
