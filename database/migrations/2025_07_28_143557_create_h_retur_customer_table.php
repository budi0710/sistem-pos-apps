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
        Schema::create('h_retur_customer', function (Blueprint $table) {
            $table->id();
            $table->char('fno_retur_cus', 9)->unique();
            $table->date('ftgl_retur_cus');
            $table->string('fnama_customer',100);
            $table->string('fsurat_jalan',100);
            $table->string('userid',20);
            $table->string('fket',200);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('h_retur_customer');
    }
};
