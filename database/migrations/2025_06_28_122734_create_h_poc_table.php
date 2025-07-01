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
        Schema::create('h_poc', function (Blueprint $table) {
            $table->id();
            $table->char('fno_poc', 7)->unique();
            $table->string('fno_poc_cus', 50);
            $table->char('kode_cus', 3);
            $table->date('ftgl_poc');
            $table->char('PPN_cus', 1);
            $table->text('description');
            $table->string('userid',20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('h_poc');
    }
};
