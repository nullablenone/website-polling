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
        Schema::create('batas_pollings', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->unique(); // Simpan alamat IP
            $table->integer('jumlah_polling')->default(0);
            $table->date('tanggal_polling')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batas_pollings');
    }
};
