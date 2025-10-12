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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('service_id');
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->date('tanggal_checkin');
            $table->date('tanggal_checkout');
            $table->string('nama_hotel');
            $table->string('harga_perkamar')->nullable();
            $table->string('jumlah_kamar');
            $table->string('catatan')->nullable();
            $table->string('type');
            $table->string('jumlah_type');
            $table->string('type_custom_special_room');
            $table->string('jumlah_kasur');
            $table->string('harga_type_custom_special_room')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
