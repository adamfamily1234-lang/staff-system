<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_structured_skills', function (Blueprint $table) {
            $table->id();

            $table->foreignId('staff_id')
                ->constrained('staff')
                ->cascadeOnDelete();

            $table->foreignId('skill_master_id')
                ->constrained('skill_masters')
                ->restrictOnDelete();

            /*
             * Sumber rekod:
             * self_declared
             * admin_added
             * supervisor_added
             */
            $table->string('record_source', 50)
                ->default('self_declared');

            /*
             * Siapa yang mewujudkan rekod ini.
             * Untuk self-declared boleh diisi dengan user staf bila login module siap.
             */
            $table->foreignId('added_by_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
             * staff_visible = staf sendiri boleh lihat
             * admin_only = hanya role dibenarkan boleh lihat
             */
            $table->string('visibility_scope', 50)
                ->default('staff_visible');

            /*
             * Tahap self-declared:
             * 1 = Asas
             * 2 = Berdikari
             * 3 = Pakar / Rujukan
             *
             * Nullable kerana admin/penyelia boleh tambah skill terus
             * tanpa self-declaration.
             */
            $table->unsignedTinyInteger('declared_level')->nullable();
            $table->timestamp('declared_at')->nullable();

            /*
             * Konteks pengalaman skill.
             */
            $table->unsignedSmallInteger('start_year')->nullable();
            $table->decimal('years_experience', 4, 1)->nullable();
            $table->string('frequency', 50)->nullable();
            $table->text('context')->nullable();

            /*
             * Bukti tidak semestinya sijil.
             */
            $table->string('evidence_type', 100)->nullable();
            $table->text('evidence_description')->nullable();

            /*
             * Status:
             * self_declared
             * pending_verification
             * verified
             * rejected
             */
            $table->string('verification_status', 50)
                ->default('self_declared');

            /*
             * Semua Tahap 1/2/3 boleh disahkan.
             * Boleh sama atau berbeza daripada declared_level.
             */
            $table->unsignedTinyInteger('verified_level')->nullable();

            $table->foreignId('verified_by_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('verified_at')->nullable();
            $table->text('verification_notes')->nullable();

            $table->text('notes')->nullable();
            $table->timestamps();

            /*
             * Satu staf = satu rekod untuk satu skill spesifik.
             */
            $table->unique(
                ['staff_id', 'skill_master_id'],
                'staff_struct_skill_unique'
            );

            $table->index(
                ['staff_id', 'verification_status'],
                'staff_struct_skill_status_idx'
            );

            $table->index(
                ['staff_id', 'visibility_scope'],
                'staff_struct_skill_visibility_idx'
            );

            $table->index(
                ['record_source', 'verification_status'],
                'staff_struct_skill_source_status_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_structured_skills');
    }
};
