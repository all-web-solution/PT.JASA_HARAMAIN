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
        Schema::create('catering_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('catering_id')->constrained('caterings')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('qty_pack');
            $table->string('days');
            $table->string('total_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catering_bookings');
    }
};
