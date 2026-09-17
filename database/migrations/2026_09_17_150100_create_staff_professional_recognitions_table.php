<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_professional_recognitions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('staff_id');

            $table->unsignedBigInteger(
                'professional_recognition_master_id'
            );

            $table->string('registration_no', 150)->nullable();
            $table->date('registered_awarded_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign(
                'staff_id',
                'staff_prof_rec_staff_fk'
            )
                ->references('id')
                ->on('staff')
                ->cascadeOnDelete();

            $table->foreign(
                'professional_recognition_master_id',
                'staff_prof_rec_master_fk'
            )
                ->references('id')
                ->on('professional_recognition_masters')
                ->restrictOnDelete();

            $table->unique(
                ['staff_id', 'professional_recognition_master_id'],
                'staff_prof_rec_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_professional_recognitions');
    }
};
