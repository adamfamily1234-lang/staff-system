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
        Schema::create('staff_educations', function (Blueprint $table) {
            $table->id();

            // Hubungan dengan staf
            $table->foreignId('staff_id')
                ->constrained('staff')
                ->cascadeOnDelete();

            // Peringkat pendidikan
            $table->string('level');

            // Nama / detail kelayakan
            $table->string('qualification');

            // Nama institusi
            $table->string('institution')->nullable();

            // Tahun tamat / diperoleh
            $table->unsignedSmallInteger('year')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_educations');
    }
};