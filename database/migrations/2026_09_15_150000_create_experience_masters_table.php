<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experience_masters', function (Blueprint $table) {
            $table->id();
            $table->string('field_type', 150);
            $table->text('main_field_category');
            $table->string('main_system_category', 255);
            $table->string('sub_field', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('field_type');
            $table->index('main_system_category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experience_masters');
    }
};
