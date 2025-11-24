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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel orders
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            // PENTING: Gunakan decimal untuk uang, jangan string.
            // (15, 0) artinya total 15 digit, 0 digit di belakang koma (cocok untuk Rupiah)
            $table->decimal('jumlah_bayar', 15, 0);

            // Gunakan tipe date agar mudah difilter/sort
            $table->date('tanggal_bayar');

            // Boleh kosong (nullable), karena mungkin bukti diupload belakangan
            $table->string('bukti_pembayaran')->nullable();

            // Berikan nilai default, misal 'pending' atau 'verified'
            $table->string('status')->default('pending');

            // Catatan boleh kosong
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
