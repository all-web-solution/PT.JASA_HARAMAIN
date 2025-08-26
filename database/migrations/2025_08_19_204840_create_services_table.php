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
            $table->string('contact_person', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->date('departure_date')->nullable();
            $table->date('return_date')->nullable();
            $table->integer('total_jamaah')->nullable();
            $table->integer('jumlah_jamaah')->nullable();
            $table->decimal('harga_bandara', 15, 2)->nullable();
            $table->string('nama_bandara')->nullable();
            $table->date('kedatangan_jamaah')->nullable();
            $table->integer('jumlah_pendamping')->nullable();
            $table->string('services_type', 50)->nullable(); // transport, tour, dll
            $table->timestamps();
        });
        Schema::create('service_planes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->string('plane_name', 100)->nullable();
            $table->decimal('ticket_price', 15, 2)->nullable();
            $table->integer('jumlah_jamaah')->nullable();
            $table->timestamps();
        });

        // 3. service_hotels
        Schema::create('service_hotels', function (Blueprint $table) {
            $table->id();
           $table->unsignedInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->string('nama_hotel', 150);
            $table->date('tanggal_hotel')->nullable();
            $table->decimal('harga_hotel', 15, 2)->nullable();
            $table->integer('pax_hotel')->nullable();
            $table->enum('lokasi', ['makkah', 'madinah', 'lainnya'])->default('lainnya');
            $table->timestamps();
        });

        // 4. service_handlings
        Schema::create('service_handlings', function (Blueprint $table) {
            $table->id();
           $table->unsignedInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->string('handling_type', 100);
            $table->decimal('harga', 15, 2)->nullable();
            $table->integer('jumlah')->nullable();
            $table->timestamps();
        });

        // 5. service_pendampings
        Schema::create('service_pendampings', function (Blueprint $table) {
            $table->id();
           $table->unsignedInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->string('nama', 100)->nullable();
            $table->integer('jumlah')->nullable();
            $table->decimal('harga', 15, 2)->nullable();
            $table->timestamps();
        });

        // 6. service_contents
       Schema::create('service_contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->string('content_type', 50); // itinerary, fasilitas, catatan
            $table->text('content_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_contents');
        Schema::dropIfExists('service_pendampings');
        Schema::dropIfExists('service_handlings');
        Schema::dropIfExists('service_hotels');
        Schema::dropIfExists('service_planes');
        Schema::dropIfExists('services');
    }
};
