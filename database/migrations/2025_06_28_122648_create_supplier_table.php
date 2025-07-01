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
        Schema::create('supplier', function (Blueprint $table) {
            $table->id();
            $table->char('kode_sup', 3)->unique();
            $table->string('nama_sup', 100);
            $table->string('notelp_sup', 15);
            $table->string('alamat_sup', 100);
            $table->string('email_sup', 50);
            $table->string('PPN_sup', 1);
            $table->string('NPWP_sup', 20);
            $table->string('PPH23_sup', 1);
            $table->string('CP_sup', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier');
    }
};
