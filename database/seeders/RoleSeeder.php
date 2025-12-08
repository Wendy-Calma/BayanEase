<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Full system administrator with all privileges'
            ],
            [
                'name' => 'staff',
                'display_name' => 'Staff Member',
                'description' => 'Barangay staff member who can process requests'
            ],
            [
                'name' => 'resident',
                'display_name' => 'Resident',
                'description' => 'Barangay resident who can submit document requests'
            ]
        ];

        foreach ($roles as $role) {
            \App\Models\Role::updateOrCreate(
                ['name' => $role['name']],
                $role
            );
        }
    }
}
