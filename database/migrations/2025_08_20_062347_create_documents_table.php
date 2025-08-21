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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('pelanggan_id');
$table->foreign('pelanggan_id')->references('id')->on('pelanggans')->onDelete('cascade');
            $table->string('visa');
            $table->string('vaksin'); // e.g., 'pesawat', 'bus', 'mobil');
            $table->string('tasreh_roudoh'); // e.g., 'pesawat', 'bus', 'mobil');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
