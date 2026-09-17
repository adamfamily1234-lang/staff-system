<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('professional_recognition_masters', function (Blueprint $table) {
            $table->id();
            $table->string('regulator_category', 150);
            $table->string('issuer', 255);
            $table->string('registration_scope', 150);
            $table->string('professional_level', 255);
            $table->string('prefix_title', 100)->nullable();
            $table->string('suffix_title', 100)->nullable();
            $table->unsignedInteger('prefix_priority')->nullable();
            $table->unsignedInteger('display_order');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('regulator_category');
            $table->index('issuer');
            $table->index('display_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('professional_recognition_masters');
    }
};
