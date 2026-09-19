<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('staff_professional_contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('staff')->cascadeOnDelete();
            $table->string('activity_type')->nullable();
            $table->string('activity_name');
            $table->string('role')->nullable();
            $table->string('organization')->nullable();
            $table->string('level')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('reference_no')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['staff_id', 'start_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_professional_contributions');
    }
};
