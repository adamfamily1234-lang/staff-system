<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skill_masters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skill_category_id')
                ->constrained('skill_categories')
                ->cascadeOnDelete();

            $table->string('code', 80)->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['skill_category_id', 'display_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skill_masters');
    }
};
