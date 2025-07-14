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
        Schema::create('rls_brg_sup', function (Blueprint $table) {
            $table->id();
            $table->char('fno_rbs', 3)->unique();
            $table->char('kode_sup', 3);
            $table->char('kode_bg', 5);
            $table->string('fn_brg_sup', 100);
            $table->string('fsatuan_beli', 20);
            $table->decimal('fharga_beli')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rls_brg_sup');
    }
};
