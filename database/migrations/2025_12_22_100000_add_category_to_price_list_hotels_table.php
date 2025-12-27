<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('price_list_hotels', function (Blueprint $table) {
            $table->string('category')->nullable()->after('nama_hotel');
        });
    }

    public function down(): void
    {
        Schema::table('price_list_hotels', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};

