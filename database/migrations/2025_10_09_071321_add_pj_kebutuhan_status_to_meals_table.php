<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('meals', function (Blueprint $table) {
            $table->string('pj')->nullable()->after('jumlah');
            $table->string('kebutuhan')->default('-')->after('pj');
            $table->enum('status', ['nego', 'deal', 'batal', 'tahap persiapan', 'tahap produksi', 'done'])->default('nego');
        });
    }
    public function down(): void
    {
        Schema::table('meals', function (Blueprint $table) {
            $table->dropColumn(['pj', 'kebutuhan', 'status']);
        });
    }
};
