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
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pelanggan_id');
            $table->foreign('pelanggan_id')->references('id')->on('pelanggans')->onDelete('cascade');
            $table->string('jamaah');
            $table->integer('service');;
            $table->date('tanggal_keberangkatan');
            $table->date('tanggal_kepulangan');
            $table->foreignId('plane_id')->constrained('planes')->onDelete('cascade');

            $table->foreignId('bus_id')->nullable()->constrained('buses')->onDelete('cascade');

            $table->foreignId('makkah_hotel_id')->constrained('makkah_hotels')->onDelete('cascade');

            $table->foreignId('madina_hotel_id')->constrained('madinah_hotels')->onDelete('cascade');

            $table->string('visa');
            $table->string('vaksin');
            $table->string('bandara_indonesia');
            $table->string('bandara_jeddah');
            $table->date('checkout_hotel_makkah')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
