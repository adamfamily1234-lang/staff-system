<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('competency_masters', function (Blueprint $table) {
            $table->id();
            $table->string('discipline', 100);
            $table->string('code', 20)->unique();
            $table->string('domain');
            $table->string('competency_title');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('competency_masters');
    }
};
