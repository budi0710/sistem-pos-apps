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
        Schema::create('h_pos', function (Blueprint $table) {
            $table->id();
            $table->char('fno_pos', 9)->unique();
            $table->char('kode_sup', 3);
            $table->date('ftgl_pos');
            $table->char('PPN', 1)->default(0);
            $table->string('description', 100);
            $table->string('userid', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('h_pos');
    }
};
