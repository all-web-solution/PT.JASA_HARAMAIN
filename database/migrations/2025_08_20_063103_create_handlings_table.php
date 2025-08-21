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
            $table->string('bandara_indonesia');
            $table->string('bandara_mekkah'); // e.g., 'pesawat', 'bus', 'mobil');
            $table->string('hotel'); // e.g., 'pesawat', 'bus', 'mobil');
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
