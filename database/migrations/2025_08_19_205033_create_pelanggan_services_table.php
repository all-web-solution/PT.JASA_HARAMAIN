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
        Schema::create('pelanggan_services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pelanggan_id')->unsigned();
            $table->foreign('pelanggan_id')->references('id')->on('pelanggans')->onDelete('cascade');
            $table->integer('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->integer('quantity')->default(1); // jumlah (misal 2 tiket, 3 box nasi)
            $table->decimal('total_price', 15, 2)->nullable();
            $table->date('start_date')->nullable(); // tanggal mulai service
            $table->date('end_date')->nullable();   // tanggal selesai service
            $table->text('notes')->nullable();      // catatan khusus user
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggan_services');
    }
};
