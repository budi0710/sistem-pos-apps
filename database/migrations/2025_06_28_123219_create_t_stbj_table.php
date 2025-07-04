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
        Schema::create('t_stbj', function (Blueprint $table) {
            $table->id();
            $table->char('fno_stbj', 9);
            $table->char('fk_brj', 5);
            $table->decimal('fq_stbj')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_stbj');
    }
};
