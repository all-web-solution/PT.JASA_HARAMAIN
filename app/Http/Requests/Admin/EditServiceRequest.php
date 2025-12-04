<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Document;
use App\Models\GuideItems;
use App\Models\TourItem;
use App\Models\MealItem;
use App\Models\Dorongan;
use App\Models\ContentItem;
use App\Models\Meal;

class EditServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $services = $this->input('services', []);

        $isMainTransportationSelected = in_array('transportasi', $services);
        $isHotelSelected = in_array('hotel', $services);
        $isDocumentSelected = in_array('dokumen', $services);
        $isHandlingSelected = in_array('handling', $services);
        $isPendampingSelected = in_array('pendamping', $services);
        $isKontenSelected = in_array('konten', $services);
        $isReyalSelected = in_array('reyal', $services);
        $isTourSelected = in_array('tour', $services);
        $isMealSelected = in_array('meals', $services);
        $isDoronganSelected = in_array('dorongan', $services);
        $isWakafSelected = in_array('waqaf', $services);
        $isBadalSelected = in_array('badal', $services);

        // Sub-Layanan
        $transportationTypes = $this->input('transportation', []);
        $isBusSelected = $isMainTransportationSelected && in_array('bus', $transportationTypes);
        $isPlaneSelected = $isMainTransportationSelected && in_array('airplane', $transportationTypes);

        $handlingTypes = $this->input('handlings', []);
        $isHandlingHotelSelected = $isHandlingSelected && in_array('hotel', $handlingTypes);
        $isHandlingBandaraSelected = $isHandlingSelected && in_array('bandara', $handlingTypes);

        // ID Helper (Untuk mendeteksi apakah ini Update atau Insert baru saat Edit)
        // Pastikan input hidden ini ada di edit.blade.php
        $existingHandlingHotelId = $this->input('handling_hotel_id');
        $existingHandlingBandaraId = $this->input('handling_bandara_id');

        $reyalType = $this->input('tipe');

        return [
            'travel' => 'required|exists:pelanggans,id',
            'services' => 'required|array',
            'tanggal_keberangkatan' => 'required|date',
            'tanggal_kepulangan' => 'required|date',
            'total_jamaah' => 'required|integer',
            'email' => 'required|email',
            'phone' => 'required|string',

            // --- TRANSPORTASI ---
            'transportation' => $isMainTransportationSelected ? 'required|array|min:1' : 'nullable|array',

            'transportation_id' => $isBusSelected ? 'required|array|min:1' : 'nullable|array',
            'transportation_id.*' => $isBusSelected ? 'required|exists:transportations,id' : 'nullable',
            'rute_id' => $isBusSelected ? 'required|array|min:1' : 'nullable|array',
            'rute_id.*' => $isBusSelected ? 'required|exists:routes,id' : 'nullable',
            'tanggal_transport' => $isBusSelected ? 'required|array|min:1' : 'nullable|array',
            'tanggal_transport.*.dari' => $isBusSelected ? 'required|date' : 'nullable|date',
            'tanggal_transport.*.sampai' => $isBusSelected ? 'required|date|after_or_equal:tanggal_transport.*.dari' : 'nullable|date',

            'rute' => $isPlaneSelected ? 'required|array|min:1' : 'nullable|array',
            'tanggal' => $isPlaneSelected ? 'required|array|min:1' : 'nullable|array',
            'rute.*' => $isPlaneSelected ? 'required|string' : 'nullable|string',
            'tanggal.*' => $isPlaneSelected ? 'required|date' : 'nullable|date',
            'maskapai.*' => $isPlaneSelected ? 'required|string' : 'nullable|string',
            'jumlah.*' => $isPlaneSelected ? 'required|integer|min:1' : 'nullable|integer|min:0',

            // --- HOTEL ---
            'nama_hotel' => $isHotelSelected ? 'required|array|min:1' : 'nullable|array',
            'nama_hotel.*' => $isHotelSelected ? 'required|string|filled' : 'nullable',
            'tanggal_checkin' => $isHotelSelected ? 'required|array|min:1' : 'nullable|array',
            'tanggal_checkin.*' => $isHotelSelected ? 'required|date' : 'nullable',
            'tanggal_checkout' => $isHotelSelected ? 'required|array|min:1' : 'nullable|array',
            'tanggal_checkout.*' => $isHotelSelected ? 'required|date|after:tanggal_checkin.*' : 'nullable',
            'jumlah_kamar' => $isHotelSelected ? 'required|array|min:1' : 'nullable|array',
            'jumlah_kamar.*' => $isHotelSelected ? 'required|integer|min:1' : 'nullable',
            'hotel_data' => [
                $isHotelSelected ? 'required' : 'nullable',
                'array',
                function ($attribute, $value, $fail) use ($isHotelSelected) {
                    if (!$isHotelSelected)
                        return;

                    $allHotels = request()->input('nama_hotel', []);
                    $hotelIndexes = array_keys($allHotels);

                    foreach ($hotelIndexes as $index) {
                        if (!isset($value[$index]) || !is_array($value[$index]) || count($value[$index]) < 1) {
                            $nama = $allHotels[$index] ?? null;
                            $label = !empty($nama) ? "'$nama'" : "ke-" . ($index + 1);

                            $fail("Hotel $label wajib memiliki minimal satu Tipe Kamar yang dipilih.");
                        }
                    }
                },
            ],
            'hotel_data.*.*.jumlah' => $isHotelSelected ? 'required|integer|min:1' : 'nullable',

            // --- DOKUMEN ---
            'child_documents' => 'nullable|array',
            'child_documents.*' => 'exists:document_childrens,id',
            'base_documents' => 'nullable|array',
            'base_documents.*' => 'exists:documents,id',

            // Validasi utama menggunakan 'dokumen_parent_id' karena ini adalah checkbox yang di-submit dari blade edit
            'dokumen_parent_id' => [
                $isDocumentSelected ? 'required' : 'nullable', // Wajib ada minimal 1 parent terpilih jika service aktif
                'array',
                function ($attribute, $value, $fail) use ($isDocumentSelected) {
                    if (!$isDocumentSelected || empty($value) || !is_array($value))
                        return;

                    // Ambil dokumen parent yang memiliki children
                    $parentsWithChildren = Document::whereIn('id', $value)
                        ->has('childrens')->with('childrens')->get();

                    // Ambil input child yang dipilih user
                    $selectedChildIds = $this->input('child_documents', []);

                    foreach ($parentsWithChildren as $parent) {
                        $validChildIds = $parent->childrens->pluck('id')->toArray();
                        // Cek apakah ada irisan antara child yang dipilih dengan child milik parent ini
                        $hasSelectedChild = !empty(array_intersect($selectedChildIds, $validChildIds));

                        if (!$hasSelectedChild) {
                            $fail("Dokumen '{$parent->name}' memiliki opsi turunan. Anda wajib memilih minimal satu sub-jenis dokumen tersebut.");
                        }
                    }
                },
            ],

            // --- HANDLING (PERBAIKAN LOGIKA FILE REQUIRED) ---
            'handlings' => $isHandlingSelected ? 'required|array|min:1' : 'nullable',

            // Handling Hotel
            'nama_hotel_handling' => $isHandlingHotelSelected ? 'required|string|max:255' : 'nullable',
            'tanggal_hotel_handling' => $isHandlingHotelSelected ? 'required|date' : 'nullable',
            'harga_hotel_handling' => $isHandlingHotelSelected ? 'required|numeric|min:0' : 'nullable',
            'pax_hotel_handling' => $isHandlingHotelSelected ? 'required|integer|min:1' : 'nullable',

            // File: Wajib JIKA Hotel dipilih DAN (Data Baru / ID Kosong)
            'kode_booking_hotel_handling' => [
                Rule::requiredIf(fn() => $isHandlingHotelSelected && empty($existingHandlingHotelId)),
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120'
            ],
            'rumlis_hotel_handling' => [
                Rule::requiredIf(fn() => $isHandlingHotelSelected && empty($existingHandlingHotelId)),
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf,xls,xlsx',
                'max:5120'
            ],
            'identitas_hotel_handling' => [
                Rule::requiredIf(fn() => $isHandlingHotelSelected && empty($existingHandlingHotelId)),
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120'
            ],

            // Handling Bandara
            'nama_bandara_handling' => $isHandlingBandaraSelected ? 'required|string|max:255' : 'nullable',
            'jumlah_jamaah_handling' => $isHandlingBandaraSelected ? 'required|integer|min:1' : 'nullable',
            'harga_bandara_handling' => $isHandlingBandaraSelected ? 'required|numeric|min:0' : 'nullable',
            'kedatangan_jamaah_handling' => $isHandlingBandaraSelected ? 'required|date' : 'nullable',
            'nama_supir' => $isHandlingBandaraSelected ? 'required|string|max:255' : 'nullable',

            // File: Wajib JIKA Bandara dipilih DAN (Data Baru / ID Kosong)
            'paket_info' => [
                Rule::requiredIf(fn() => $isHandlingBandaraSelected && empty($existingHandlingBandaraId)),
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120'
            ],
            'identitas_koper_bandara_handling' => [
                Rule::requiredIf(fn() => $isHandlingBandaraSelected && empty($existingHandlingBandaraId)),
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120'
            ],

            // --- PENDAMPING ---
            'jumlah_pendamping' => $isPendampingSelected ? 'required|array' : 'nullable',
            'tanggal_pendamping' => $isPendampingSelected ? 'required|array' : 'nullable',

            // --- KONTEN ---
            'jumlah_konten' => [
                $isKontenSelected ? 'required' : 'nullable',
                'array',
                function ($attribute, $value, $fail) use ($isKontenSelected) {
                    if (!$isKontenSelected)
                        return;
                    $hasSelection = false;
                    foreach ($value as $qty) {
                        if ((int) $qty > 0) {
                            $hasSelection = true;
                            break;
                        }
                    }
                    if (!$hasSelection) {
                        $fail('Anda memilih layanan Konten, wajib mengisi jumlah minimal untuk satu item konten.');
                    }
                },
            ],
            'tanggal_konten' => [
                $isKontenSelected ? 'required' : 'nullable',
                'array',
                function ($attribute, $dates, $fail) use ($isKontenSelected) {
                    if (!$isKontenSelected)
                        return;
                    $jumlahs = $this->input('jumlah_konten', []);
                    foreach ($jumlahs as $contentId => $qty) {
                        if ((int) $qty > 0) {
                            if (empty($dates[$contentId])) {
                                $content = ContentItem::find($contentId);
                                $name = $content ? $content->name : 'Konten';
                                $fail("Tanggal pelaksanaan wajib diisi untuk $name.");
                            }
                        }
                    }
                }
            ],

            // --- REYAL ---
            'tipe' => $isReyalSelected ? 'required|in:tamis,tumis' : 'nullable',
            'tanggal_penyerahan' => $isReyalSelected ? 'required|date' : 'nullable',
            'jumlah_rupiah' => ($isReyalSelected && $reyalType === 'tamis') ? 'required|numeric|min:1' : 'nullable',
            'kurs_tamis' => ($isReyalSelected && $reyalType === 'tamis') ? 'required|numeric|min:1' : 'nullable',
            'jumlah_reyal' => ($isReyalSelected && $reyalType === 'tumis') ? 'required|numeric|min:1' : 'nullable',
            'kurs_tumis' => ($isReyalSelected && $reyalType === 'tumis') ? 'required|numeric|min:1' : 'nullable',

            // --- TOUR ---
            'tour_id' => $isTourSelected ? 'required|array|min:1' : 'nullable',
            'tour_tanggal' => [
                $isTourSelected ? 'required' : 'nullable',
                'array',
                function ($attribute, $dates, $fail) use ($isTourSelected) {
                    if (!$isTourSelected)
                        return;
                    $selectedTours = $this->input('tour_id', []);
                    foreach ($selectedTours as $tourId) {
                        if (empty($dates[$tourId])) {
                            $tour = TourItem::find($tourId);
                            $name = $tour ? $tour->name : 'Tour';
                            $fail("Tanggal pelaksanaan wajib diisi untuk tour: $name.");
                        }
                    }
                }
            ],
            'tour_transport' => $isTourSelected ? 'required|array' : 'nullable',

            // --- MEALS ---
            'jumlah_meals' => [
                $isMealSelected ? 'required' : 'nullable',
                'array',
                function ($attribute, $value, $fail) use ($isMealSelected) {
                    if (!$isMealSelected)
                        return;
                    $hasSelection = false;
                    foreach ($value as $qty) {
                        if ((int) $qty > 0) {
                            $hasSelection = true;
                            break;
                        }
                    }
                    if (!$hasSelection) {
                        $fail('Anda memilih layanan Meals, wajib mengisi jumlah minimal untuk satu menu.');
                    }
                },
            ],
            'meals_dari' => [
                $isMealSelected ? 'required' : 'nullable',
                'array',
                function ($attribute, $dates, $fail) use ($isMealSelected) {
                    if (!$isMealSelected)
                        return;
                    $jumlahs = $this->input('jumlah_meals', []);
                    foreach ($jumlahs as $id => $qty) {
                        if ((int) $qty > 0) {
                            if (empty($dates[$id])) {
                                $item = Meal::find($id);
                                $name = $item ? $item->name : 'Meals';
                                $fail("Tanggal awal pelaksanaan wajib diisi untuk $name.");
                            }
                        }
                    }
                }
            ],
            'meals_sampai' => [
                $isMealSelected ? 'required' : 'nullable',
                'array',
                function ($attribute, $dates, $fail) use ($isMealSelected) {
                    if (!$isMealSelected)
                        return;
                    $jumlahs = $this->input('jumlah_meals', []);
                    foreach ($jumlahs as $id => $qty) {
                        if ((int) $qty > 0) {
                            if (empty($dates[$id])) {
                                $item = Meal::find($id);
                                $name = $item ? $item->name : 'Meals';
                                $fail("Tanggal akhir pelaksanaan wajib diisi untuk $name.");
                            }
                        }
                    }
                }
            ],

            // --- DORONGAN ---
            'jumlah_dorongan' => [
                $isDoronganSelected ? 'required' : 'nullable',
                'array',
                function ($attribute, $value, $fail) use ($isDoronganSelected) {
                    if (!$isDoronganSelected)
                        return;
                    $hasSelection = false;
                    foreach ($value as $qty) {
                        if ((int) $qty > 0) {
                            $hasSelection = true;
                            break;
                        }
                    }
                    if (!$hasSelection) {
                        $fail('Anda memilih layanan Dorongan, wajib mengisi jumlah minimal untuk satu item.');
                    }
                },
            ],
            'dorongan_tanggal' => [
                $isDoronganSelected ? 'required' : 'nullable',
                'array',
                function ($attribute, $dates, $fail) use ($isDoronganSelected) {
                    if (!$isDoronganSelected)
                        return;
                    $jumlahs = $this->input('jumlah_dorongan', []);
                    foreach ($jumlahs as $id => $qty) {
                        if ((int) $qty > 0) {
                            if (empty($dates[$id])) {
                                $item = Dorongan::find($id);
                                $name = $item ? $item->name : 'Dorongan';
                                $fail("Tanggal pelaksanaan wajib diisi untuk $name.");
                            }
                        }
                    }
                }
            ],

            // --- WAKAF ---
            'jumlah_wakaf' => [
                $isWakafSelected ? 'required' : 'nullable',
                'array',
                function ($attribute, $value, $fail) use ($isWakafSelected) {
                    if (!$isWakafSelected)
                        return;
                    $hasSelection = false;
                    foreach ($value as $qty) {
                        if ((int) $qty > 0) {
                            $hasSelection = true;
                            break;
                        }
                    }
                    if (!$hasSelection) {
                        $fail('Anda memilih layanan Waqaf, wajib mengisi jumlah minimal untuk satu item waqaf.');
                    }
                },
            ],

            // --- BADAL ---
            'nama_badal' => $isBadalSelected ? 'required|array|min:1' : 'nullable',
            'harga_badal' => $isBadalSelected ? 'required|array|min:1' : 'nullable',
            'tanggal_badal' => $isBadalSelected ? 'required|array|min:1' : 'nullable',
            'nama_badal.*' => $isBadalSelected ? 'required|string|filled' : 'nullable',
            'harga_badal.*' => $isBadalSelected ? 'required|numeric|min:0' : 'nullable',
            'tanggal_badal.*' => $isBadalSelected ? 'required|date' : 'nullable',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (in_array('pendamping', $this->input('services', []))) {
                $jumlahs = $this->input('jumlah_pendamping', []);
                $dates = $this->input('tanggal_pendamping', []);
                $hasSelection = false;

                foreach ($jumlahs as $id => $qty) {
                    if ((int) $qty > 0) {
                        $hasSelection = true;

                        $start = $dates[$id]['dari'] ?? null;
                        $end = $dates[$id]['sampai'] ?? null;

                        if (empty($start)) {
                            $validator->errors()->add("tanggal_pendamping.{$id}.dari", "Tanggal 'Dari' wajib diisi.");
                        }
                        if (empty($end)) {
                            $validator->errors()->add("tanggal_pendamping.{$id}.sampai", "Tanggal 'Sampai' wajib diisi.");
                        }

                        if (!empty($start) && !empty($end)) {
                            if ($end < $start) {
                                $validator->errors()->add("tanggal_pendamping.{$id}.sampai", "Tanggal sampai tidak boleh kurang dari tanggal dari.");
                            }
                        }
                    }
                }

                // Validasi Global (Minimal 1 dipilih)
                if (!$hasSelection) {
                    $validator->errors()->add('jumlah_pendamping', 'Anda memilih layanan Pendamping, wajib mengisi jumlah minimal untuk satu pendamping.');
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            // Transport
            'transportation.required' => 'Anda memilih layanan Transportasi, wajib memilih minimal salah satu sub-layanan (Pesawat atau Transportasi Darat).',
            'transportation.min' => 'Anda memilih layanan Transportasi, wajib memilih minimal salah satu sub-layanan (Pesawat atau Transportasi Darat).',
            'transportation_id.required' => 'Anda memilih Transportasi Darat, tapi belum menambahkan satu pun item transportasi.',
            'transportation_id.min' => 'Anda memilih Transportasi Darat, tapi belum menambahkan satu pun item transportasi.',
            'rute_id.required' => 'Rute wajib dipilih untuk setiap transportasi darat.',
            'rute_id.min' => 'Rute wajib dipilih untuk setiap transportasi darat.',
            'rute_id.*.required' => 'Rute wajib dipilih untuk setiap transportasi darat.',
            'tanggal_transport.required' => 'Tanggal transportasi darat wajib diisi.',
            'tanggal_transport.min' => 'Tanggal transportasi darat wajib diisi.',
            'tanggal_transport.*.dari.required' => 'Tanggal "Dari" wajib diisi untuk setiap transportasi darat.',
            'tanggal_transport.*.sampai.required' => 'Tanggal "Sampai" wajib diisi untuk setiap transportasi darat.',
            'tanggal_transport.*.sampai.after_or_equal' => 'Tanggal "Sampai" harus sama atau setelah Tanggal "Dari".',
            'rute.required' => 'Anda memilih Tiket Pesawat, tapi belum menambahkan satu pun rute penerbangan.',
            'rute.min' => 'Anda memilih Tiket Pesawat, tapi belum menambahkan satu pun rute penerbangan.',
            'tanggal.required' => 'Tanggal keberangkatan wajib diisi untuk setiap penerbangan.',
            'tanggal.min' => 'Tanggal keberangkatan wajib diisi untuk setiap penerbangan.',
            'rute.*.required' => 'Rute (contoh: JKT-JED) wajib diisi untuk setiap penerbangan.',
            'tanggal.*.required' => 'Tanggal keberangkatan wajib diisi untuk setiap penerbangan.',
            'maskapai.*.required' => 'Nama maskapai wajib diisi untuk setiap penerbangan.',
            'harga_tiket.*.required' => 'Harga tiket wajib diisi untuk setiap penerbangan.',
            'jumlah.*.required' => 'Jumlah jamaah wajib diisi untuk setiap penerbangan.',
            'jumlah.*.min' => 'Jumlah jamaah harus minimal 1.',

            // Hotel
            'hotel_data.required' => 'Data detail hotel wajib diisi (Mohon pilih tipe kamar).',
            'nama_hotel.required' => 'Anda memilih layanan Hotel, wajib mengisi data minimal satu hotel.',
            'nama_hotel.*.required' => 'Nama hotel wajib diisi.',
            'nama_hotel.*.filled' => 'Nama hotel tidak boleh kosong.',
            'tanggal_checkin.*.required' => 'Tanggal Check-in wajib diisi.',
            'tanggal_checkout.*.required' => 'Tanggal Check-out wajib diisi.',
            'tanggal_checkout.*.after' => 'Tanggal Check-out harus setelah tanggal Check-in.',
            'jumlah_kamar.*.required' => 'Total jumlah kamar wajib diisi.',
            'jumlah_kamar.*.min' => 'Total jumlah kamar minimal 1.',
            'jumlah_kamar.*.integer' => 'Total jumlah kamar harus berupa angka.',

            'hotel_data.*.*.jumlah.required' => 'Jumlah kamar untuk tipe yang dipilih wajib diisi.',
            'hotel_data.*.*.jumlah.min' => 'Jumlah kamar untuk tipe yang dipilih minimal 1.',

            // Dokumen
            'dokumen_parent_id.required' => 'Anda memilih layanan Dokumen, wajib memilih minimal satu jenis dokumen.',
            'dokumen_parent_id.array' => 'Format dokumen tidak valid.',

            'handlings.required' => 'Anda memilih layanan Handling, wajib memilih jenis handling (Hotel atau Bandara).',

            // Handling Hotel
            'nama_hotel_handling.required' => 'Nama Hotel (Handling) wajib diisi.',
            'tanggal_hotel_handling.required' => 'Tanggal pelaksanaan Handling Hotel wajib diisi.',
            'harga_hotel_handling.required' => 'Harga Handling Hotel wajib diisi.',
            'pax_hotel_handling.required' => 'Jumlah Pax Handling Hotel wajib diisi.',
            'harga_hotel_handling.numeric' => 'Harga Handling Hotel harus berupa angka.',
            'pax_hotel_handling.integer' => 'Jumlah Pax Handling Hotel harus berupa angka bulat.',
            'kode_booking_hotel_handling.required' => 'File Kode Booking wajib diupload untuk handling hotel.',
            'rumlis_hotel_handling.required' => 'File Room List wajib diupload untuk handling hotel.',
            'identitas_hotel_handling.required' => 'File Identitas Koper wajib diupload untuk handling hotel.',

            // Handling Bandara
            'nama_bandara_handling.required' => 'Nama Bandara wajib diisi.',
            'jumlah_jamaah_handling.required' => 'Jumlah jamaah (Handling Bandara) wajib diisi.',
            'jumlah_jamaah_handling.integer' => 'Jumlah jamaah (Handling Bandara) harus berupa angka bulat.',
            'jumlah_jamaah_handling.min' => 'Jumlah jamaah (Handling Bandara) minimal 1.',
            'harga_bandara_handling.required' => 'Harga Handling Bandara wajib diisi.',
            'harga_bandara_handling.numeric' => 'Harga Handling Bandara harus berupa angka.',
            'kedatangan_jamaah_handling.required' => 'Tanggal kedatangan jamaah wajib diisi.',
            'nama_supir.required' => 'Nama supir wajib diisi.',
            'identitas_koper_bandara_handling.required' => 'File Identitas Koper Bandara wajib diupload.',
            'paket_info' => 'File Paket Info wajib diupload.',

            // Pendamping
            'jumlah_pendamping.required' => 'Anda memilih layanan Pendamping, wajib mengisi jumlah minimal untuk satu pendamping.',
            'tanggal_pendamping.required' => 'Tanggal pendamping wajib diisi.',
            'tanggal_pendamping.*.dari.required' => 'Tanggal "Dari" wajib diisi.',
            'tanggal_pendamping.*.sampai.required' => 'Tanggal "Sampai" wajib diisi.',

            // Konten
            'jumlah_konten.required' => 'Data konten wajib diisi.',

            // Reyal
            'tipe.required' => 'Tipe penukaran (Tamis/Tumis) wajib dipilih.',
            'tipe.in' => 'Tipe penukaran tidak valid.',
            'tanggal_penyerahan.required' => 'Tanggal penyerahan uang wajib diisi.',

            'jumlah_rupiah.required' => 'Jumlah Rupiah wajib diisi untuk transaksi Tamis.',
            'kurs_tamis.required' => 'Kurs Tamis wajib diisi.',

            'jumlah_reyal.required' => 'Jumlah Reyal wajib diisi untuk transaksi Tumis.',
            'kurs_tumis.required' => 'Kurs Tumis wajib diisi.',

            // Tour
            'tour_id.required' => 'Mohon pilih minimal satu lokasi tour.',
            'tour_transport' => 'Jenis transportasi wajib diisi.',

            // Meals
            'jumlah_meals.required' => 'Data meals wajib diisi.',

            // Dorongan
            'jumlah_dorongan.required' => 'Data dorongan wajib diisi.',
            'dorongan_tanggal' => 'Tanggal Dorongan wajib diisi',

            // Pesan Error Waqaf
            'jumlah_wakaf.required' => 'Data waqaf wajib diisi.',

            // Pesan Error Badal
            'nama_badal.required' => 'Data jamaah badal wajib diisi.',
            'nama_badal.*.required' => 'Nama jamaah yang dibadalkan wajib diisi.',
            'harga_badal.*.required' => 'Harga badal wajib diisi.',
            'tanggal_badal.*.required' => 'Tanggal pelaksanaan badal wajib diisi.',
        ];
    }

    private function hasHandling($type)
    {
        return is_array($this->handlings) && in_array($type, $this->handlings);
    }
}
