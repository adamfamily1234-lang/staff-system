<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_placements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('staff_id')
                ->constrained('staff')
                ->cascadeOnDelete();

            $table->foreignId('grade_master_id')
                ->constrained('grade_masters');

            $table->string('grade_status');

            $table->foreignId('position_master_id')
                ->nullable()
                ->constrained('position_masters')
                ->nullOnDelete();

            $table->foreignId('placement_type_master_id')
                ->nullable()
                ->constrained('placement_type_masters')
                ->nullOnDelete();

            $table->foreignId('department_id')
                ->nullable()
                ->constrained('departments')
                ->nullOnDelete();

            $table->foreignId('unit_id')
                ->nullable()
                ->constrained('units')
                ->nullOnDelete();

            $table->date('start_date');

            $table->date('end_date')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index([
                'staff_id',
                'start_date',
            ]);

            $table->index([
                'staff_id',
                'grade_status',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_placements');
    }
};