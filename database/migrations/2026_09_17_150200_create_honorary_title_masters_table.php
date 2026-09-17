<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('honorary_title_masters', function (Blueprint $table) {
            $table->id();
            $table->string('issuer_category', 100);
            $table->string('issuer', 255);
            $table->string('scope_level', 255);
            $table->string('award_name', 255);
            $table->string('prefix_title', 100)->nullable();
            $table->string('suffix_title', 150)->nullable();
            $table->boolean('grants_ybhg')->default(false);
            $table->unsignedInteger('display_order');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('issuer_category');
            $table->index('issuer');
            $table->index('display_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('honorary_title_masters');
    }
};
