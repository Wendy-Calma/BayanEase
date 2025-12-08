<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DocumentType;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documentTypes = [
            [
                'name' => 'Barangay Clearance',
                'code' => 'BC',
                'description' => 'A certification of good moral character issued by the barangay',
                'requirements' => 'Valid ID, Proof of Residency',
                'processing_days' => 3,
                'fee' => 50,
                'is_active' => true,
                'display_order' => 1,
            ],
            [
                'name' => 'Certificate of Residency',
                'code' => 'COR',
                'description' => 'A document certifying that a person is a resident of the barangay',
                'requirements' => 'Proof of Address, Barangay ID',
                'processing_days' => 2,
                'fee' => 50,
                'is_active' => true,
                'display_order' => 2,
            ],
            [
                'name' => 'Indigency Certificate',
                'code' => 'INDIG',
                'description' => 'A certificate issued to poor families for assistance programs',
                'requirements' => 'Income documents, Barangay ID',
                'processing_days' => 3,
                'fee' => 0,
                'is_active' => true,
                'display_order' => 3,
            ],
            [
                'name' => 'Barangay ID',
                'code' => 'BGID',
                'description' => 'Official identification card issued by the barangay',
                'requirements' => 'Birth Certificate, Proof of Address',
                'processing_days' => 5,
                'fee' => 100,
                'is_active' => true,
                'display_order' => 4,
            ],
            [
                'name' => 'Business Permit',
                'code' => 'BP',
                'description' => 'A permit required for establishing a business in the barangay',
                'requirements' => 'DTI Registration, Tax Clearance',
                'processing_days' => 3,
                'fee' => 200,
                'is_active' => true,
                'display_order' => 5,
            ],
            [
                'name' => 'Permit to Build',
                'code' => 'PTB',
                'description' => 'A permit required before construction of any structure',
                'requirements' => 'Lot Title, Architectural Plans',
                'processing_days' => 5,
                'fee' => 500,
                'is_active' => true,
                'display_order' => 6,
            ],
        ];

        foreach ($documentTypes as $type) {
            DocumentType::firstOrCreate(
                ['code' => $type['code']],
                $type
            );
        }
    }
}
