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
        Schema::create('caterings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('pelanggan_id');
            $table->foreign('pelanggan_id')->references('id')->on('pelanggans')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreignId('catering_id')->constrained('catering_items')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('caterings');
    }
};
