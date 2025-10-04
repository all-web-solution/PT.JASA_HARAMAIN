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
        Schema::create('planes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->date('tanggal_keberangkatan');
            $table->string('rute');
            $table->string('maskapai');
            $table->string('harga')->nullable();
            $table->string('tiket_berangkat')->nullable();
            $table->string('tiket_pulang')->nullable();
            $table->string('keterangan');
            $table->string('jumlah_jamaah');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planes');
    }
};
