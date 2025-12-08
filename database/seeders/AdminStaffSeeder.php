<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin role if it doesn't exist
        $adminRole = Role::firstOrCreate([
            'name' => 'admin'
        ], [
            'description' => 'Administrator role with full system access'
        ]);

        // Create staff role if it doesn't exist
        $staffRole = Role::firstOrCreate([
            'name' => 'staff'
        ], [
            'description' => 'Staff role with limited system access'
        ]);

        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@barangay.gov.ph'],
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'password' => Hash::make('Admin@123'),
                'role_id' => $adminRole->id,
                'phone_number' => '09123456789',
                'complete_address' => 'Barangay Admin Office',
                'is_active' => true
            ]
        );

        // Create staff user
        User::firstOrCreate(
            ['email' => 'staff@barangay.gov.ph'],
            [
                'first_name' => 'Staff',
                'last_name' => 'User',
                'password' => Hash::make('Staff@123'),
                'role_id' => $staffRole->id,
                'phone_number' => '09987654321',
                'complete_address' => 'Barangay Staff Office',
                'is_active' => true
            ]
        );
    }
}