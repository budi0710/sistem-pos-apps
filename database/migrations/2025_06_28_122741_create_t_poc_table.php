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
        Schema::create('t_poc', function (Blueprint $table) {
            $table->id();
            $table->char('fno_poc', 7);
            $table->char('fk_brj', 5);
            $table->char('fnos_poc', 7)->unique();
            $table->integer('fq_poc');
            $table->decimal('fharga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_poc');
    }
};
