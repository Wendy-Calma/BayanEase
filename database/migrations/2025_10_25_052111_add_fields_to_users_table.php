<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->after('id')->default(3)->constrained('roles')->onDelete('restrict');
            $table->string('first_name')->after('name');
            $table->string('last_name')->after('first_name');
            $table->string('phone_number', 15)->after('email');
            $table->text('complete_address')->after('phone_number');
            $table->string('barangay_id_number', 50)->nullable()->after('complete_address');
            $table->boolean('is_active')->default(true)->after('barangay_id_number');
            $table->timestamp('phone_verified_at')->nullable()->after('email_verified_at');
            $table->timestamp('last_login_at')->nullable()->after('phone_verified_at');
            $table->string('last_login_ip', 45)->nullable()->after('last_login_at');
        });

        // Remove the default 'name' column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->dropForeign(['role_id']);
            $table->dropColumn([
                'role_id',
                'first_name',
                'last_name',
                'phone_number',
                'complete_address',
                'barangay_id_number',
                'is_active',
                'phone_verified_at',
                'last_login_at',
                'last_login_ip',
            ]);
        });
    }
};