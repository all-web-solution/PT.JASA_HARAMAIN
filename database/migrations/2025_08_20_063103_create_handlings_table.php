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
        Schema::create('handlings', function (Blueprint $table) {
            $table->id();
                        $table->unsignedInteger('pelanggan_id');
            $table->foreign('pelanggan_id')->references('id')->on('pelanggans')->onDelete('cascade');
            $table->enum('handling_type', ['hotel', 'bandara']);

            // Hotel
            $table->string('nama_hotel')->nullable();
            $table->date('tanggal_hotel')->nullable();
            $table->decimal('harga_hotel', 15, 2)->nullable();
            $table->integer('pax_hotel')->nullable();

            // Bandara
            $table->string('nama_bandara')->nullable();
            $table->integer('jumlah_jamaah')->nullable();
            $table->decimal('harga_bandara', 15, 2)->nullable();
            $table->date('kedatangan_jamaah')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('handlings');
    }
};
