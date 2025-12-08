<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Full Name Fields
            $table->string('surname')->nullable()->after('last_name');
            $table->string('middle_name')->nullable()->after('surname');
            $table->string('nick_name')->nullable()->after('middle_name');

            // Date of Birth
            $table->string('birth_month', 2)->nullable()->after('nick_name');
            $table->integer('birth_day')->nullable()->after('birth_month');
            $table->integer('birth_year')->nullable()->after('birth_day');

            // Place of Birth
            $table->string('birth_province')->nullable()->after('birth_year');
            $table->string('birth_city')->nullable()->after('birth_province');

            // Personal Information
            $table->string('citizenship')->nullable()->after('birth_city');
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable()->after('citizenship');
            $table->enum('civil_status', ['Single', 'Married', 'Widowed', 'Separated'])->nullable()->after('gender');
            $table->string('religion')->nullable()->after('civil_status');
            $table->string('education_occupation')->nullable()->after('religion');

            // Family Information
            $table->string('spouse_name')->nullable()->after('education_occupation');
            $table->string('father_name')->nullable()->after('spouse_name');
            $table->string('mother_name')->nullable()->after('father_name');

            // Residency Information
            $table->enum('residency_type', ['Owner', 'Renter', 'Living with Family'])->nullable()->after('mother_name');
            $table->integer('residency_years')->default(0)->after('residency_type');

            // Documents
            $table->string('id_picture')->nullable()->after('residency_years');
            $table->string('digital_signature')->nullable()->after('id_picture');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'surname',
                'middle_name',
                'nick_name',
                'birth_month',
                'birth_day',
                'birth_year',
                'birth_province',
                'birth_city',
                'citizenship',
                'gender',
                'civil_status',
                'religion',
                'education_occupation',
                'spouse_name',
                'father_name',
                'mother_name',
                'residency_type',
                'residency_years',
                'id_picture',
                'digital_signature',
            ]);
        });
    }
};
