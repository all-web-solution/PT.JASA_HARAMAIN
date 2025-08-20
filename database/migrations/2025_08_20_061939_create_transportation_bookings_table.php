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
        Schema::create('transportation_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transportation_id')->constrained('transportations')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('qty_pack');
            $table->integer('total_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transportation_bookings');
    }
};
