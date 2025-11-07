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
            $table->string('total_estimasi')->nullable();
            $table->string('total_amount')->nullable();
            $table->string('invoice');
            $table->string('total_yang_dibayarkan');
            $table->string('sisa_hutang');
            $table->enum('status_pembayaran', ['estimasi', 'belum_bayar', 'belum_lunas', 'lunas'])->default('estimasi');

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
