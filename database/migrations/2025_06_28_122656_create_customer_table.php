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
        Schema::create('customer', function (Blueprint $table) {
            $table->id();
            $table->char('kode_cus', 3)->unique();
            $table->string('nama_cus', 100);
            $table->string('notelp_cus', 15);
            $table->string('alamat_cus', 100);
            $table->string('email_cus', 50);
            $table->string('PPN_cus', 1)->default(0);
            $table->string('NPWP_cus', 20);
            $table->string('PPH23_cus', 1)->default(0);
            $table->string('CP_cus', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer');
    }
};
