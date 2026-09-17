<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_honorary_titles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('staff_id')
                ->constrained('staff')
                ->cascadeOnDelete();

            $table->foreignId('honorary_title_master_id')
                ->constrained('honorary_title_masters')
                ->restrictOnDelete();

            $table->string('warrant_serial_no', 150)->nullable();
            $table->date('registered_awarded_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(
                ['staff_id', 'honorary_title_master_id'],
                'staff_honorary_title_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_honorary_titles');
    }
};
