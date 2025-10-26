<?php

namespace Database\Seeders;

use App\Models\ContentItem;
use App\Models\Document;
use App\Models\DocumentChildren;
use App\Models\Dorongan;
use App\Models\GuideItems;
use App\Models\MealItem;
use App\Models\Pelanggan;
use App\Models\Route;
use App\Models\TourItem;
use App\Models\Transportation;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Wakaf;
use Illuminate\Support\Facades\Hash;
use App\Models\TypeHotel;

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
            [
                'name' => 'Keuangan keuangan',
                'full_name' => 'Keuangan Haramaini',
                'email' => 'keuangan@gmail.com',
                'phone' => '0857486516617',
                'address' => 'Kp Tamansari',
                'role' => 'keuangan',
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
            ['document_id' => 1, 'name' => 'visa umrah', "price" => 12000],
            ['document_id' => 1, 'name' => 'visa haji', "price" => 16000],
            ['document_id' => 1, 'name' => 'visa ziarah', "price" => 20000],
            ['document_id' => 1, 'name' => 'visa personal',"price" => 5000],
            ['document_id' => 1, 'name' => 'visa group', "price" => 22000],
            ['document_id' => 2, 'name' => 'polio', "price" => 31000],
            ['document_id' => 2, 'name' => 'meningtis',  "price" => 60000],
        ];

        foreach($documentChildren as $data){
            DocumentChildren::create($data);
        }
        $wakaf = [
            ["nama" => "Al quran", "Harga" => "12000"],
            ["nama" => "Air", "Harga" => "1000"],
            ["nama" => "Mushaf", "Harga" => "16000"],
        ];

        foreach($wakaf as $item){
            Wakaf::create($item);
        }
        $dorongan = [
            ["name" => "umrah", "price" => "12.000"],
            ["name" => "makkah", "price" => "8.000"],
            ["name" => "tawaf", "price" => "7.000"],
            ["name" => "dorongan sel", "price" => "7.000"],
        ];
        foreach($dorongan as $data){
            Dorongan::create($data);
        }

        $contents= [
            ["name" => "Moment Umrah", "price" => 12000],
            ["name" => "Moment mekkah", "price" => 13000],
            ["name" => "Moment madinah", "price" => 52000],
            ["name" => "Full content", "price" => 62000],
        ];
        foreach($contents as $content){
            ContentItem::create($content);
        }

         $types = [
            ["nama_tipe" => 'Double', "jumlah" => 5000],
            ["nama_tipe" => 'Triple', "jumlah" => 12000],
            ["nama_tipe" => 'Kuint', "jumlah" => 3200],
            ["nama_tipe" => 'Kuard', "jumlah" => 15000],
        ];
        foreach($types as $type){
            TypeHotel::create($type);
        }

        $pelanggans = [
            ['foto' => '1.jpg', 'nama_travel' => 'Madinatain', 'alamat'=>'Jl. Suka-suka', 'email' => 'madinatain@travel.com', 'penanggung_jawab' => 'fulan', 'phone' => '000', 'no_ktp' => '1000', 'status' => 'active'],
            ['foto' => '1.jpg', 'nama_travel' => 'Haramain', 'alamat'=>'Jl. duka-duka', 'email' => 'haramain@travel.com', 'penanggung_jawab' => 'fulan', 'phone' => '001', 'no_ktp' => '2000', 'status' => 'active']
        ];

        foreach($pelanggans as $pelanggan){
            Pelanggan::create($pelanggan);
        }
    }
}
