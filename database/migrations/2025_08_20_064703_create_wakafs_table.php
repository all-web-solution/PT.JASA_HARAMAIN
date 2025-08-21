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
             $table->unsignedInteger('pelanggan_id');
$table->foreign('pelanggan_id')->references('id')->on('pelanggans')->onDelete('cascade');
            $table->enum('type', ['air minum', 'al quran', 'nasi box']);
            $table->text('price');
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
        Schema::dropIfExists('wakafs');
    }
};
