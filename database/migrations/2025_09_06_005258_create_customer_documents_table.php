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
        Schema::create('customer_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('service_id');
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('document_children_id')->nullable()->constrained('document_childrens')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('document_id')->constrained('documents')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('jumlah');
            $table->string('harga');
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
        Schema::dropIfExists('customer_documents');
    }
};
