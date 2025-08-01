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
        Schema::create('h_stbj', function (Blueprint $table) {
            $table->id();
            $table->char('fno_stbj', 9)->unique();
            $table->date('ftgl_stbj');
            $table->string('description',200);
            $table->string('userid',20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('h_stbj');
    }
};
