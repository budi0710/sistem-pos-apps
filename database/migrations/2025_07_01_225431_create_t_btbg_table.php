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
        Schema::create('t_btbg', function (Blueprint $table) {
            $table->id();
            $table->string('fno_btbg', 10);
            $table->char('kode_bg', 5);
            $table->decimal('fq_btbg_rcn',15)->default(0);
            $table->decimal('fq_btbg_akt',15)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_btbg');
    }
};
