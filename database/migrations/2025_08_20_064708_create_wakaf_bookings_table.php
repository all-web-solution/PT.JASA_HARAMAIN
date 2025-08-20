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
        Schema::create('wakaf_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wakaf_id')->constrained('wakafs')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('qty');
            $table->string('total_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wakaf_bookings');
    }
};
