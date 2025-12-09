<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;
use App\Models\Service;
use App\Models\Pelanggan;
use App\Models\Transportation;
use App\Models\TransportationItem;
use App\Models\Route;
use App\Models\Plane;
use App\Models\Hotel;
use App\Models\GuideItems;
use App\Models\Guide;
use App\Models\MealItem;
use App\Models\Meal;
use App\Models\ContentItem;
use App\Models\ContentCustomer;
use App\Models\Dorongan;
use App\Models\DoronganOrder;
use App\Models\Wakaf;
use App\Models\WakafCustomer;
use App\Models\TourItem;
use App\Models\Tour;
use App\Models\Badal;
use App\Models\Document;
use App\Models\DocumentChildren;
use App\Models\CustomerDocument;
use App\Models\Order;

class RandomServiceSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        $this->ensureMasterData();

        $pelangganIds = Pelanggan::pluck('id')->toArray();
        $transportIds = Transportation::pluck('id')->toArray();
        $guideIds = GuideItems::pluck('id')->toArray();
        $mealIds = MealItem::pluck('id')->toArray();
        $contentIds = ContentItem::pluck('id')->toArray();
        $doronganIds = Dorongan::pluck('id')->toArray();
        $wakafIds = Wakaf::pluck('id')->toArray();
        $tourIds = TourItem::pluck('id')->toArray();
        $docIds = Document::pluck('id')->toArray();

        $availableServices = [
            'transportasi',
            'hotel',
            'dokumen',
            'handling',
            'pendamping',
            'konten',
            'reyal',
            'tour',
            'meals',
            'dorongan',
            'waqaf',
            'badal'
        ];

        for ($i = 0; $i < 50; $i++) {
            $tanggalBerangkat = Carbon::createFromTimestamp(mt_rand(strtotime('-2 years'), time()));
            $tanggalPulang = $tanggalBerangkat->copy()->addDays(rand(5, 14));
            $numServices = rand(3, count($availableServices));
            $selectedServices = $faker->randomElements($availableServices, $numServices);
            $service = Service::create([
                'unique_code' => 'ID-' . $faker->unique()->numerify('####'),
                'pelanggan_id' => $faker->randomElement($pelangganIds),
                'services' => $selectedServices,
                'tanggal_keberangkatan' => $tanggalBerangkat->format('Y-m-d'),
                'tanggal_kepulangan' => $tanggalPulang->format('Y-m-d'),
                'total_jamaah' => rand(10, 100),
                'status' => $faker->randomElement(['nego', 'deal', 'batal', 'done']),
                'created_at' => $tanggalBerangkat,
                'updated_at' => $tanggalBerangkat,
            ]);

            $totalPrice = 0;
            if (in_array('transportasi', $selectedServices)) {
                if ($faker->boolean(70)) {
                    $harga = rand(10, 20) * 1000000;
                    Plane::create([
                        'service_id' => $service->id,
                        'tanggal_keberangkatan' => $tanggalBerangkat,
                        'rute' => 'CGK - ' . $faker->randomElement(['JED', 'MED']),
                        'maskapai' => $faker->randomElement(['Garuda', 'Saudia', 'Lion Air']),
                        'harga' => $harga,
                        'jumlah_jamaah' => $service->total_jamaah,
                        'keterangan' => 'Group Booking',
                        'created_at' => $tanggalBerangkat,
                        'updated_at' => $tanggalBerangkat,
                    ]);
                    $totalPrice += ($harga * $service->total_jamaah);
                }

                if ($faker->boolean(60) && count($transportIds) > 0) {
                    $transId = $faker->randomElement($transportIds);
                    $routePrice = rand(1, 5) * 1000000;
                    $route = Route::firstOrCreate(
                        ['transportation_id' => $transId, 'route' => 'City Tour ' . $faker->city],
                        ['price' => $routePrice]
                    );

                    TransportationItem::create([
                        'service_id' => $service->id,
                        'transportation_id' => $transId,
                        'route_id' => $route->id,
                        'dari_tanggal' => $tanggalBerangkat->copy()->addDays(1),
                        'sampai_tanggal' => $tanggalBerangkat->copy()->addDays(3),
                        'created_at' => $tanggalBerangkat,
                        'updated_at' => $tanggalBerangkat,
                    ]);
                    $totalPrice += $routePrice;
                }
            }

            if (in_array('hotel', $selectedServices)) {
                $jmlKamar = ceil($service->total_jamaah / 4);
                $hargaKamar = rand(3, 8) * 100000;
                Hotel::create([
                    'service_id' => $service->id,
                    'nama_hotel' => $faker->randomElement(['Hilton', 'Pullman', 'Swissbell']),
                    'tanggal_checkin' => $tanggalBerangkat,
                    'tanggal_checkout' => $tanggalBerangkat->copy()->addDays(rand(3, 5)),
                    'jumlah_kamar' => $jmlKamar,
                    'type' => $faker->randomElement(['Quad', 'Triple', 'Double']),
                    'jumlah_type' => $jmlKamar,
                    'harga_perkamar' => $hargaKamar,
                    'catatan' => $faker->sentence,
                    'created_at' => $tanggalBerangkat,
                    'updated_at' => $tanggalBerangkat,
                ]);
                $totalPrice += ($hargaKamar * $jmlKamar * 3);
            }

            if (in_array('dokumen', $selectedServices) && count($docIds) > 0) {
                $randomDocs = $faker->randomElements($docIds, rand(1, 3));
                foreach ($randomDocs as $docId) {
                    $child = DocumentChildren::where('document_id', $docId)->inRandomOrder()->first();
                    $hargaDokumen = $child ? $child->price : rand(50000, 500000);
                    CustomerDocument::create([
                        'service_id' => $service->id,
                        'document_id' => $docId,
                        'document_children_id' => $child ? $child->id : null,
                        'jumlah' => $service->total_jamaah,
                        'harga' => $hargaDokumen,
                        'created_at' => $tanggalBerangkat,
                        'updated_at' => $tanggalBerangkat,
                    ]);
                    $totalPrice += ($hargaDokumen * $service->total_jamaah);
                }
            }

            if (in_array('handling', $selectedServices)) {
                if ($faker->boolean()) {
                    $hHotel = $service->handlings()->create(['name' => 'hotel', 'created_at' => $tanggalBerangkat, 'updated_at' => $tanggalBerangkat]);
                    $hHotel->handlingHotels()->create([
                        'nama' => 'Handling Hotel ' . $faker->word,
                        'tanggal' => $tanggalBerangkat,
                        'harga' => 50000,
                        'pax' => $service->total_jamaah,
                        'kode_booking' => 'BK-' . rand(100, 999),
                        'rumlis' => 'file_dummy.pdf',
                        'identitas_koper' => 'img_dummy.jpg',
                        'created_at' => $tanggalBerangkat,
                        'updated_at' => $tanggalBerangkat,
                    ]);
                    $totalPrice += (50000 * $service->total_jamaah);
                }
                if ($faker->boolean()) {
                    $hPlane = $service->handlings()->create(['name' => 'bandara', 'created_at' => $tanggalBerangkat, 'updated_at' => $tanggalBerangkat]);
                    $hPlane->handlingPlanes()->create([
                        'nama_bandara' => 'Soetta',
                        'jumlah_jamaah' => $service->total_jamaah,
                        'harga' => 75000,
                        'kedatangan_jamaah' => $tanggalBerangkat,
                        'nama_supir' => $faker->name,
                        'paket_info' => 'info_dummy.pdf',
                        'identitas_koper' => 'img_dummy.jpg',
                        'created_at' => $tanggalBerangkat,
                        'updated_at' => $tanggalBerangkat,
                    ]);
                    $totalPrice += (75000 * $service->total_jamaah);
                }
            }

            if (in_array('pendamping', $selectedServices) && count($guideIds) > 0) {
                $guideId = $faker->randomElement($guideIds);
                $guidePrice = rand(1, 3) * 1000000;
                Guide::create([
                    'service_id' => $service->id,
                    'guide_id' => $guideId,
                    'jumlah' => rand(1, 3),
                    'muthowif_dari' => $tanggalBerangkat,
                    'muthowif_sampai' => $tanggalPulang,
                    'created_at' => $tanggalBerangkat,
                    'updated_at' => $tanggalBerangkat,
                ]);
                $totalPrice += $guidePrice;
            }

            if (in_array('meals', $selectedServices) && count($mealIds) > 0) {
                $mealId = $faker->randomElement($mealIds);
                Meal::create([
                    'service_id' => $service->id,
                    'meal_id' => $mealId,
                    'jumlah' => $service->total_jamaah * 3,
                    'dari_tanggal' => $tanggalBerangkat,
                    'sampai_tanggal' => $tanggalPulang,
                    'created_at' => $tanggalBerangkat,
                    'updated_at' => $tanggalBerangkat,
                ]);
                $totalPrice += (25000 * $service->total_jamaah * 3);
            }

            if (in_array('konten', $selectedServices) && count($contentIds) > 0) {
                $contentId = $faker->randomElement($contentIds);
                ContentCustomer::create([
                    'service_id' => $service->id,
                    'content_id' => $contentId,
                    'jumlah' => 1,
                    'tanggal_pelaksanaan' => $tanggalBerangkat->copy()->addDays(2),
                    'created_at' => $tanggalBerangkat,
                    'updated_at' => $tanggalBerangkat,
                ]);
                $totalPrice += 500000;
            }

            if (in_array('dorongan', $selectedServices) && count($doronganIds) > 0) {
                $doronganId = $faker->randomElement($doronganIds);
                DoronganOrder::create([
                    'service_id' => $service->id,
                    'dorongan_id' => $doronganId,
                    'jumlah' => rand(1, 5),
                    'tanggal_pelaksanaan' => $tanggalBerangkat->copy()->addDays(rand(1, 3)),
                    'created_at' => $tanggalBerangkat,
                    'updated_at' => $tanggalBerangkat,
                ]);
                $totalPrice += 100000;
            }

            if (in_array('waqaf', $selectedServices) && count($wakafIds) > 0) {
                $wakafId = $faker->randomElement($wakafIds);
                $qty = rand(1, 20);
                WakafCustomer::create([
                    'service_id' => $service->id,
                    'wakaf_id' => $wakafId,
                    'jumlah' => $qty,
                    'created_at' => $tanggalBerangkat,
                    'updated_at' => $tanggalBerangkat,
                ]);
                $totalPrice += (100000 * $qty);
            }

            if (in_array('badal', $selectedServices)) {
                Badal::create([
                    'service_id' => $service->id,
                    'name' => $faker->name,
                    'tanggal_pelaksanaan' => $tanggalBerangkat->copy()->addDays(2),
                    'price' => 1500000,
                    'status' => 'nego',
                    'created_at' => $tanggalBerangkat,
                    'updated_at' => $tanggalBerangkat,
                ]);
                $totalPrice += 1500000;
            }

            $totalBayar = $faker->boolean(80) ? rand(1000000, $totalPrice) : 0;
            $statusBayar = $totalBayar >= $totalPrice ? 'lunas' : ($totalBayar > 0 ? 'belum_lunas' : 'belum_bayar');

            Order::create([
                'service_id' => $service->id,
                'invoice' => 'INV-' . strtoupper($faker->bothify('??####')),
                'total_estimasi' => $totalPrice,
                'total_amount_final' => $service->status === 'deal' || $service->status === 'done' ? $totalPrice : null,
                'total_yang_dibayarkan' => $totalBayar,
                'sisa_hutang' => max(0, $totalPrice - $totalBayar),
                'status_pembayaran' => $statusBayar,
                'status_harga' => $service->status === 'deal' ? 'fix' : 'provisional',

                'created_at' => $tanggalBerangkat,
                'updated_at' => $tanggalBerangkat,
            ]);
        }
    }

    private function ensureMasterData()
    {
        if (Pelanggan::count() == 0) {
            Pelanggan::create([
                'nama_travel' => 'Travel Test Default',
                'email' => 'test@travel.com',
                'penanggung_jawab' => 'Admin',
                'phone' => '000000000',
                'alamat' => '-',
                'status' => 'active'
            ]);
        }

        if (Transportation::count() == 0) {
            Transportation::create(['nama' => 'Bus Default', 'kapasitas' => 40, 'fasilitas' => '-', 'harga' => 1000000]);
        }

        if (GuideItems::count() == 0) {
            GuideItems::create(['nama' => 'Guide Default', 'harga' => 150000, 'keterangan' => 'Default']);
        }

        if (Document::count() == 0) {
            Document::create(['name' => 'Dokumen Default']);
        }

        if (MealItem::count() == 0) {
            MealItem::create(['name' => 'Nasi Box', 'price' => 25000]);
        }

        if (ContentItem::count() == 0) {
            ContentItem::create(['name' => 'Video Editing', 'price' => 500000]);
        }

        if (Dorongan::count() == 0) {
            Dorongan::create(['name' => 'Kursi Roda', 'price' => 100000]);
        }

        if (Wakaf::count() == 0) {
            Wakaf::create(['nama' => 'Al-Quran', 'harga' => 50000]);
        }
    }
}
