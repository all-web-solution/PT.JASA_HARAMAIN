<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CustomerDocument;
use Carbon\Carbon;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelanggan_id',
        'services',
        'tanggal_keberangkatan',
        'tanggal_kepulangan',
        'total_jamaah',
        'status',
        'unique_code'
    ];

    // Relasi ke Travel
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id', 'id');
    }
    protected $casts = [
        'services' => 'array',
    ];
    public function planes()
    {
        return $this->hasMany(Plane::class);
    }
    public function transportationItem()
    {
        return $this->hasMany(TransportationItem::class, 'service_id');
    }
    public function hotels()
    {
        return $this->hasMany(Hotel::class, 'service_id');
    }
    public function handlings()
    {
        return $this->hasMany(Handling::class, );
    }
    public function meals()
    {
        return $this->hasMany(Meal::class, );
    }
    public function guides()
    {
        return $this->hasMany(Guide::class, 'service_id', 'id');
    }
    public function tours()
    {
        return $this->hasMany(Tour::class, 'service_id');
    }
    public function documents()
    {
        return $this->hasMany(CustomerDocument::class, 'service_id');
    }
    public function filess()
    {
        return $this->hasMany(File::class, 'service_id');
    }
    public function exchanges()
    {
        return $this->hasMany(Exchange::class, 'service_id');
    }
    public function wakafs()
    {
        return $this->hasMany(WakafCustomer::class, 'service_id');
    }
    public function dorongans()
    {
        return $this->hasMany(DoronganOrder::class, 'service_id');
    }
    public function contents()
    {
        return $this->hasMany(ContentCustomer::class, );
    }
    public function badals()
    {
        return $this->hasMany(Badal::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class, );
    }
    public function pendamping()
    {
        return $this->belongsTo(User::class, 'pendamping_id');
    }

    public static function totalJamaahBulanIni()
    {
        return self::whereMonth('tanggal_keberangkatan', Carbon::now()->month)
            ->whereYear('tanggal_keberangkatan', Carbon::now()->year)
            ->sum('total_jamaah');
    }

    /**
     * Daftar NAMA FUNGSI RELASI yang dianggap sebagai 'item layanan'
     * dan harus dicek status & harganya.
     * * PENTING: Sesuaikan nama string di array ini agar SAMA PERSIS
     * dengan nama fungsi relasi yang ada di model Service ini.
     */
    public function getItemRelationsList(): array
    {
        return [
            'planes',
            'transportationItem',
            'hotels',
            'meals',
            'guides',
            'tours',
            'documents',
            'exchanges', // Menggunakan 'exchanges' sesuai nama relasi
            'wakafs',
            'dorongans',
            'contents',
            'badals',
            // 'handlings' (akan di-handle secara nested di helper bawah)
        ];
        // Catatan: Relasi 'handlings' akan di-handle terpisah
        // di getAllItemsFromService karena strukturnya nested.
    }

    /**
     * Mengumpulkan semua item layanan dari semua relasi yang relevan
     * ke dalam satu Collection.
     * * PENTING: Pastikan relasi-relasi di atas SUDAH DI-EAGER LOAD
     * (menggunakan ->with([...])) di controller sebelum memanggil fungsi ini.
     */
    public function getAllItemsFromService(): \Illuminate\Support\Collection
    {
        $allItems = collect([]);

        // 1. Loop semua relasi non-nested dari daftar
        foreach ($this->getItemRelationsList() as $relationName) {
            if ($this->relationLoaded($relationName)) {
                $items = $this->$relationName;
                if ($items) {
                    $allItems = $allItems->merge($items);
                }
            }
        }

        // 2. Handle relasi nested 'handlings' secara terpisah
        if ($this->relationLoaded('handlings')) {
            foreach ($this->handlings as $handling) {
                // Pastikan relasi di dalam handling juga di-load
                if ($handling->relationLoaded('handlingHotels')) {
                    $allItems = $allItems->merge($handling->handlingHotels);
                }
                if ($handling->relationLoaded('handlingPlanes')) {
                    $allItems = $allItems->merge($handling->handlingPlanes);
                }
            }
        }

        return $allItems;
    }
}
