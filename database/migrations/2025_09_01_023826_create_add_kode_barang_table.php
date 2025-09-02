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
        Schema::table('handling_hotels', function (Blueprint $table) {
            $table->string('kode_booking');
            $table->string('rumlis');
            $table->string('identitas_koper');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('handling_hotels', function (Blueprint $table) {
            //
        });
    }
};
