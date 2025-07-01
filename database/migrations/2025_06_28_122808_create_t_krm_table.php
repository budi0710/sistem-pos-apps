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
        Schema::create('t_krm', function (Blueprint $table) {
            $table->id();
            $table->char('fno_krm', 7)->unique();
            $table->char('fnos_poc', 7)->unique();
            $table->integer('fq_krm')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_krm');
    }
};
