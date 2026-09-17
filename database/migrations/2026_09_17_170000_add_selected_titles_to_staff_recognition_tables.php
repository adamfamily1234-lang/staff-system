<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff_professional_recognitions', function (Blueprint $table) {
            $table->string('selected_prefix_title', 100)
                ->nullable()
                ->after('professional_recognition_master_id');

            $table->string('selected_suffix_title', 150)
                ->nullable()
                ->after('selected_prefix_title');
        });

        Schema::table('staff_honorary_titles', function (Blueprint $table) {
            $table->string('selected_prefix_title', 100)
                ->nullable()
                ->after('honorary_title_master_id');

            $table->string('selected_suffix_title', 150)
                ->nullable()
                ->after('selected_prefix_title');
        });
    }

    public function down(): void
    {
        Schema::table('staff_professional_recognitions', function (Blueprint $table) {
            $table->dropColumn([
                'selected_prefix_title',
                'selected_suffix_title',
            ]);
        });

        Schema::table('staff_honorary_titles', function (Blueprint $table) {
            $table->dropColumn([
                'selected_prefix_title',
                'selected_suffix_title',
            ]);
        });
    }
};
