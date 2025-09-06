<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\DocumentChildren;
use App\Models\GuideItems;
use App\Models\MealItem;
use App\Models\Route;
use App\Models\TourItem;
use App\Models\Transportation;
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
                'role' => 'Transportasi & tiket',
            ],
            [
                'name' => 'Visa dan acara',
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
                'name' => 'Konten dan dokumentasi',
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

         $pendampings = [
            [
                'nama' => 'Muthawif kelas premium',
                'harga' => 12000,
                'keterangan' => 'Lorem ipsum',
            ],
            [
                'nama' => 'Muthawif kelas standart',
                'harga' => 1000,
                'keterangan' => 'Lorem ipsum',
            ],
            [
                'nama' => 'Muthawifah',
                'harga' => 8000,
                'keterangan' => 'Muthawifah',
            ],
            [
                'nama' => 'Team leader',
                'harga' => 1300,
                'keterangan' => 'kata kata',
            ],
        ];

        foreach ($pendampings as $p) {
           GuideItems::create($p);
        }

        $transportations = [
            [
                'nama' => 'Bus Eksekutif',
                'kapasitas' => 50,
                'fasilitas' => 'AC, Reclining Seat, LCD TV',
                'harga' => 500000,
            ],
            [
                'nama' => 'Bus Pariwisata',
                'kapasitas' => 40,
                'fasilitas' => 'AC, Reclining Seat',
                'harga' => 400000,
            ],
            [
                'nama' => 'Mobil Minibus',
                'kapasitas' => 15,
                'fasilitas' => 'AC, Audio System',
                'harga' => 200000,
            ],
            [
                'nama' => 'Mobil SUV',
                'kapasitas' => 7,
                'fasilitas' => 'AC, Audio System, GPS',
                'harga' => 250000,
            ],
        ];

        foreach ($transportations as $t) {
           Transportation::create($t);
        }
         $tours = [
            ['name' => 'Makkah'],
            ['name' => 'Madinah'],
            ['name' => 'Al Ula'],
            ['name' => 'Thoif'],
        ];

        foreach ($tours as $tour) {
            TourItem::create($tour);
        }

        $meals = [
           [ "name" => "Nasi Box",
            "price" => "15000"],
           [ "name" => "Buffle Hotel",
            "price" => "10000"],
           [ "name" => "snack",
            "price" => "6000"],
        ];

        foreach($meals as $meal){
            MealItem::create($meal);
        }
        $routes = [
            ['transportation_id' => 1, "route" => "jeddah to makkah" , "price" => 250],
            ['transportation_id' => 1, "route" => "makkah to ziyarat" , "price" => 170],
            ['transportation_id' => 1, "route" => "makkah - madinah, madinah - makkah" , "price" => 450],
            ['transportation_id' => 1, "route" => "madina to ziyarat" , "price" => 170],
            ['transportation_id' => 1, "route" => "makkah to jeddah" , "price" => 250],
            ['transportation_id' => 1, "route" => "jeddah to madina" , "price" => 250],
            ['transportation_id' => 2, "route" => "jeddah to makkah" , "price" => 250],
            ['transportation_id' => 2, "route" => "makkah to ziyarat" , "price" => 170],
            ['transportation_id' => 2, "route" => "makkah - madinah, madinah - makkah" , "price" => 450],
            ['transportation_id' => 2, "route" => "madina to ziyarat" , "price" => 170],
            ['transportation_id' => 2, "route" => "makkah to jeddah" , "price" => 250],
            ['transportation_id' => 2, "route" => "jeddah to madina" , "price" => 250],
            ['transportation_id' => 3, "route" => "jeddah to makkah" , "price" => 250],
            ['transportation_id' => 3, "route" => "makkah to ziyarat" , "price" => 170],
            ['transportation_id' => 3, "route" => "makkah - madinah, madinah - makkah" , "price" => 450],
            ['transportation_id' => 3, "route" => "madina to ziyarat" , "price" => 170],
            ['transportation_id' => 3, "route" => "makkah to jeddah" , "price" => 250],
            ['transportation_id' => 3, "route" => "jeddah to madina" , "price" => 250],
            ['transportation_id' => 4, "route" => "jeddah to makkah" , "price" => 250],
            ['transportation_id' => 4, "route" => "makkah to ziyarat" , "price" => 170],
            ['transportation_id' => 4, "route" => "makkah - madinah, madinah - makkah" , "price" => 450],
            ['transportation_id' => 4, "route" => "madina to ziyarat" , "price" => 170],
            ['transportation_id' => 4, "route" => "makkah to jeddah" , "price" => 250],
            ['transportation_id' => 4, "route" => "jeddah to madina" , "price" => 250],
        ];
        foreach($routes as $route){
            Route::create($route);
        }

        $documents = [
            ["name" => "visa"],
            ["name" => "vaksin"],
            ["name" => "siskopatuh"]
        ];
        foreach($documents as $document){
            Document::create($document);
        }

        $documentChildren = [
            ['document_id' => 1, 'name' => 'visa umrah'],
            ['document_id' => 1, 'name' => 'visa haji'],
            ['document_id' => 1, 'name' => 'visa ziarah'],
            ['document_id' => 1, 'name' => 'visa personal'],
            ['document_id' => 1, 'name' => 'visa group'],
            ['document_id' => 2, 'name' => 'polio'],
            ['document_id' => 2, 'name' => 'meningtis'],
        ];

        foreach($documentChildren as $data){
            DocumentChildren::create($data);
        }
    }
}
