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
        Schema::create('madinah_hotels', function (Blueprint $table) {
            $table->id();
            $table->date('check_in');
            $table->date('check_out');
            $table->string('hotel_name');
            $table->string('room_type');
            $table->string('bintang')->nullable(); // Optional field for hotel star rating
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('madinah_hotels');
    }
};
