<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_competencies', function (Blueprint $table) {
            $table->id();

            $table->foreignId('staff_id')
                ->constrained('staff')
                ->cascadeOnDelete();

            $table->foreignId('competency_master_id')
                ->constrained('competency_masters')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('competency_level');
            $table->date('achievement_date')->nullable();
            $table->string('certificate_no', 150)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(
                ['staff_id', 'competency_master_id'],
                'staff_competency_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_competencies');
    }
};
