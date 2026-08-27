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
        Schema::create('staff_skills', function (Blueprint $table) {
            $table->id();

            // Hubungan dengan staf
            $table->foreignId('staff_id')
                ->constrained('staff')
                ->cascadeOnDelete();

            // Nama kemahiran
            $table->string('skill');

            // Tahap kemahiran
            $table->string('level');

            // Keterangan tambahan
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_skills');
    }
};