<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_courses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('staff_id')
                ->constrained('staff')
                ->cascadeOnDelete();

            $table->foreignId('course_field_type_id')
                ->nullable()
                ->constrained('course_field_types')
                ->nullOnDelete();

            $table->foreignId('course_main_category_id')
                ->nullable()
                ->constrained('course_main_categories')
                ->nullOnDelete();

            $table->foreignId('course_sub_category_id')
                ->nullable()
                ->constrained('course_sub_categories')
                ->nullOnDelete();

            $table->string('course_name');

            $table->string('organizer')->nullable();

            $table->date('start_date')->nullable();

            $table->date('end_date')->nullable();

            $table->string('venue')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_courses');
    }
};