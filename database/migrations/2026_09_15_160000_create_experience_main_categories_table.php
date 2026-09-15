<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experience_main_categories', function (Blueprint $table) {
            $table->id();
            $table->string('field_type', 150);
            $table->string('name', 255);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['field_type', 'name']);
            $table->index(['field_type', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experience_main_categories');
    }
};
