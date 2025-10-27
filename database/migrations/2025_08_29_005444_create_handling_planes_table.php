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
        Schema::create('handling_planes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('handling_id')->constrained('handlings')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('nama_bandara');
            $table->string('jumlah_jamaah');
            $table->string('harga');
            $table->date('kedatangan_jamaah');
            $table->enum('status', ['nego', 'deal', 'batal', 'tahap persiapan', 'tahap produksi', 'done'])->default('nego');
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
        Schema::dropIfExists('handling_planes');
    }
};
