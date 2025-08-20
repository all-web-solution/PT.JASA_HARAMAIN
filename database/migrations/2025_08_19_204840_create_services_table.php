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
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subcategory_id')->unsigned();
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('cascade');
            $table->string('name'); // contoh: Visa Umroh, Tiket Pesawat, Mutowwif Premium
            $table->text('description')->nullable();
            $table->decimal('price', 15, 2)->nullable(); // harga
            $table->string('currency', 10)->default('SAR')->nullable(); // default Riyal
            $table->integer('duration')->nullable(); // durasi layanan (misal hari)
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
