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
        Schema::create('wakafs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('harga');
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
        Schema::dropIfExists('wakafs');
    }
};
