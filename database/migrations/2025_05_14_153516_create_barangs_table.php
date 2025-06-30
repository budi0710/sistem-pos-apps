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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->char('kode_bg', 5)->unique();
            $table->string('partname', 50);
            $table->string('partno', 50);
            $table->char('fk_sat', 2);
            $table->char('fk_jenis', 2);
            $table->decimal('fberat_netto')->default(0);
            $table->text('description');
            $table->decimal('harga')->default(0);
            $table->decimal('saldo_awal')->default(0);
            $table->decimal('brg_in')->default(0);
            $table->decimal('brg_out')->default(0);
            $table->string('fgambar_brg');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
