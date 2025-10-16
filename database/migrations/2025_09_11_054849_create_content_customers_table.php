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
        Schema::create('content_customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('service_id');
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('content_id')->constrained('content_items')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('jumlah');
            $table->string('keterangan')->nullable();
            $table->enum('status', ['nego', 'deal', 'batal', 'tahap persiapan', 'tahap produksi', 'done'])->default('nego');
            $table->date('tanggal_pelaksanaaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_customers');
    }
};
