<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff_work_experiences', function (Blueprint $table) {
            $table->string('field_type', 150)
                ->nullable()
                ->after('experience_main_category_id');

            $table->string('system_category', 255)
                ->nullable()
                ->after('field_type');

            $table->string('other_main_category', 255)
                ->nullable()
                ->after('system_category');

            $table->string('other_system_category', 255)
                ->nullable()
                ->after('other_main_category');

            $table->string('other_sub_field', 255)
                ->nullable()
                ->after('other_system_category');
        });

        // Backfill rekod lama yang menggunakan master data.
        DB::table('staff_work_experiences')
            ->join(
                'experience_masters',
                'staff_work_experiences.experience_master_id',
                '=',
                'experience_masters.id'
            )
            ->update([
                'staff_work_experiences.field_type' =>
                    DB::raw('experience_masters.field_type'),
                'staff_work_experiences.system_category' =>
                    DB::raw('experience_masters.main_system_category'),
            ]);

        // Rekod "Lain-lain" lama dipindahkan ke medan baru.
        DB::table('staff_work_experiences')
            ->whereNull('experience_master_id')
            ->whereNotNull('other_experience')
            ->whereNull('other_sub_field')
            ->update([
                'other_sub_field' => DB::raw('other_experience'),
            ]);
    }

    public function down(): void
    {
        Schema::table('staff_work_experiences', function (Blueprint $table) {
            $table->dropColumn([
                'field_type',
                'system_category',
                'other_main_category',
                'other_system_category',
                'other_sub_field',
            ]);
        });
    }
};
