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
        Schema::create('staff_service_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')
        ->constrained()
        ->cascadeOnDelete();

    // Maklumat Perkhidmatan
    $table->string('staff_no')->unique();

    $table->string('field_of_study')->nullable();
    $table->string('group')->nullable();
    $table->string('classification')->nullable();
    $table->string('scheme')->nullable();
    $table->string('scheme_category')->nullable();
    $table->string('appointment_type')->nullable();

    $table->string('position')->nullable();
    $table->string('grade')->nullable();

    $table->foreignId('department_id')
        ->nullable()
        ->constrained()
        ->nullOnDelete();

    $table->foreignId('unit_id')
        ->nullable()
        ->constrained()
        ->nullOnDelete();

    $table->date('service_start_date')->nullable();
    $table->string('service_status')->nullable();
    $table->date('appointment_date')->nullable();
    $table->date('confirmation_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_service_records');
    }
};
