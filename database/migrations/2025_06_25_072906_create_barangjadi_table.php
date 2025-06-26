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
        Schema::create('barangjadi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('fk_brj', 5)->unique();
            $table->char('fk_jns_brj', 2);
            $table->string('fn_brj', 50);
            $table->string('fpartno', 50);
            $table->decimal('fbrt_neto');
            $table->decimal('fbrt_bruto');
            $table->string('fdimensi');
            $table->string('fgambar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangjadi');
    }
};
