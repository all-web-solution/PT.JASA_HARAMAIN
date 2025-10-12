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
        Schema::create('handling_hotels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('handling_id')->constrained('handlings')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('nama')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('harga')->nullable();
            $table->string('pax')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('handling_hotels');
    }
};
