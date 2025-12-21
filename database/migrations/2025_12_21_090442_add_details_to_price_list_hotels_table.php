<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('price_list_hotels', function (Blueprint $table) {
            // Menambahkan kolom baru dengan 'nullable' agar data lama tidak error
            $table->date('tanggal_checkOut')->nullable();
            $table->text('catatan')->nullable()->after('tanggal_checkOut');
            $table->text('add_on')->nullable()->after('catatan'); // Text karena isinya mungkin panjang
            $table->string('supplier_utama')->nullable()->after('add_on');
            $table->string('kontak_supplier_utama')->nullable()->after('supplier_utama');
            $table->string('supplier_cadangan')->nullable()->after('kontak_supplier_utama');
            $table->string('kontak_supplier_cadangan')->nullable()->after('supplier_cadangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('price_list_hotels', function (Blueprint $table) {
            // Hapus kolom jika rollback
            $table->dropColumn([
                'tanggal_checkOut',
                'catatan',
                'add_on',
                'supplier_utama',
                'kontak_supplier_utama',
                'supplier_cadangan',
                'kontak_supplier_cadangan'
            ]);
        });
    }
};
