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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('service_id');
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('invoice');
            $table->decimal('total_estimasi', 15, 0)->nullable();
            $table->decimal('total_yang_dibayarkan', 15, 0)->default(0);
            $table->decimal('sisa_hutang', 15, 0)->default(0);
            $table->decimal('total_amount_final', 15, 0)->nullable();
            $table->string('status_harga')->default('estimasi');
            $table->enum('status_pembayaran', ['belum_bayar', 'belum_lunas', 'lunas'])->default('belum_bayar');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
