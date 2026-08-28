<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grade_masters', function (Blueprint $table) {
            $table->id();

            $table->string('grade_code')->unique();

            $table->unsignedSmallInteger('ranking_order');

            $table->string('grade_category');

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grade_masters');
    }
};