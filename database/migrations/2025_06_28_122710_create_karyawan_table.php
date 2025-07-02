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
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();
            $table->char('fnik', 5)->unique();
            $table->char('fno_ktp',16);
            $table->string('fnama_kry',50);
            $table->char('fkelamin',1);
            $table->string('fno_telp',15);
            $table->text('falamat');
            $table->char('ftatus_nikah',1);
            $table->char('fk_jabatan', 2);
            $table->char('fk_unitkerja', 2);
            $table->string('Fphoto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};
