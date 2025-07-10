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
        Schema::create('h_btbg', function (Blueprint $table) {
            $table->id();
            $table->string('fno_btbg', 10)->unique();
            $table->char('fk_brj', 5);
            $table->date('ftgl_btbg');
            $table->string('description');
            $table->string('userid', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('h_btbg');
    }
};
