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
        Schema::create('guides', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('service_id');
            $table->unsignedBigInteger('guide_id'); // <- tambahkan ini

            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('guide_id')
                ->references('id')
                ->on('guide_items')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
                $table->string('jumlah');
                $table->string('keterangan')->nullable();
                $table->enum('status', ['nego', 'deal', 'batal', 'tahap persiapan', 'tahap produksi', 'done'])->default('nego');
                $table->date('muthowif_dari');
                $table->date('muthowif_sampai');
                $table->string('supplier')->nullable();
                $table->string('harga_dasar')->nullable();
                $table->string('harga_jual')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guides');
    }
};
