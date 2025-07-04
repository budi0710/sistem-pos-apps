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
        Schema::create('t_pos', function (Blueprint $table) {
            $table->id();
            $table->char('fno_pos', 9);
            $table->char('fno_spo', 7)->unique();
            $table->char('kode_bg', 5);
            $table->decimal('fq_pos')->default(0);
            $table->decimal('fharga')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_pos');
    }
};
