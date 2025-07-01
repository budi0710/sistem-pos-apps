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
        Schema::create('h_krm', function (Blueprint $table) {
            $table->id();
            $table->char('fno_krm', 7)->unique();
            $table->date('ftgl_krm');
            $table->char('kode_cus', 3);
            $table->string('fno_poc', 50);
            $table->string('fnama_supir',50);
            $table->string('fno_plat_mobil',10);
            $table->string('decription');
            $table->string('userid',20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('h_krm');
    }
};
