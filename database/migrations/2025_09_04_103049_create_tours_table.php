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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('service_id');
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            // ubah jadi nullable
            $table->foreignId('transportation_id')->nullable()->constrained('transportations')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('tour_id')->nullable()->constrained('tour_items')->cascadeOnDelete()->cascadeOnUpdate();
            $table->date("tanggal_keberangkatan");
            $table->string('supplier')->nullable();
            $table->string('harga_dasar')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
