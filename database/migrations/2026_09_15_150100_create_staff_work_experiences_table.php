<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_work_experiences', function (Blueprint $table) {
            $table->id();

            $table->foreignId('staff_id')
                ->constrained('staff')
                ->cascadeOnDelete();

            $table->foreignId('experience_master_id')
                ->nullable()
                ->constrained('experience_masters')
                ->nullOnDelete();

            // Digunakan apabila pegawai pilih "Lain-lain".
            $table->string('other_experience', 255)->nullable();

            // Dalam sumber asal dua medan ini ialah text field.
            $table->string('ministry_department', 255)->nullable();
            $table->string('location_division', 255)->nullable();

            $table->date('start_date');
            $table->date('end_date')->nullable();

            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['staff_id', 'start_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_work_experiences');
    }
};
