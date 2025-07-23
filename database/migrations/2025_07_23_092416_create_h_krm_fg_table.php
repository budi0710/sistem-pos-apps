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
        Schema::create('h_krm_fg', function (Blueprint $table) {
            $table->id();
            $table->char('fno_krm_fg', 9)->unique();
            $table->date('ftgl_krm_fg');
            $table->string('fn_jenis_krm',50);
            $table->string('ftujuan',50);
            $table->string('falamat',255);
            $table->string('fsupir',50);
            $table->string('fket',100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('h_krm_fg');
    }
};
