<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff_work_experiences', function (Blueprint $table) {
            $table->foreignId('experience_main_category_id')
                ->nullable()
                ->after('experience_master_id')
                ->constrained('experience_main_categories')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('staff_work_experiences', function (Blueprint $table) {
            $table->dropConstrainedForeignId(
                'experience_main_category_id'
            );
        });
    }
};
