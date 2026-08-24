<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            // Maklumat Peribadi
    $table->string('name');
    $table->string('ic_no')->unique();
    $table->string('prefix_title')->nullable();
    $table->string('suffix_title')->nullable();
    $table->string('honours')->nullable();

    $table->string('gender')->nullable();
    $table->date('date_of_birth')->nullable();
    $table->string('nationality')->nullable();
    $table->string('birth_state')->nullable();
    $table->string('race')->nullable();
    $table->string('religion')->nullable();
    $table->string('marital_status')->nullable();

    $table->boolean('former_police_military')->default(false);

    $table->string('housing_type')->nullable();
    $table->string('housing_loan')->nullable();

    $table->text('residential_address')->nullable();
    $table->string('city')->nullable();
    $table->string('postcode')->nullable();
    $table->string('state')->nullable();

    $table->string('mobile_phone')->nullable();
    $table->string('official_email')->nullable();
    $table->string('personal_email')->nullable();

    $table->text('office_address')->nullable();
    $table->string('office_block')->nullable();
    $table->string('office_phone')->nullable();
    $table->string('office_fax')->nullable();

    $table->string('retirement_scheme')->nullable();
    $table->string('epf_number')->nullable();
    $table->string('income_tax_number')->nullable();
    $table->string('salary_scheme')->nullable();

    $table->date('optional_retirement_date')->nullable();
    $table->unsignedSmallInteger('optional_retirement_year')->nullable();

    $table->string('mandatory_retirement_option')->nullable();
    $table->unsignedSmallInteger('mandatory_retirement_year')->nullable();

    $table->date('latest_property_declaration')->nullable();

    $table->string('photo')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
