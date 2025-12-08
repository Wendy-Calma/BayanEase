<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DocumentRequest;
use App\Models\RequestStatusHistory;
use App\Models\User;
use Carbon\Carbon;

class DocumentRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get test users
        $residentUsers = User::whereHas('role', function ($q) {
            $q->where('name', 'resident');
        })->get();

        $staffUsers = User::whereHas('role', function ($q) {
            $q->where('name', 'staff');
        })->get();

        if ($residentUsers->isEmpty()) {
            return;
        }

        // Create test requests with various statuses
        $testRequests = [
            [
                'user_id' => $residentUsers->first()->id,
                'document_type_id' => 1,
                'purpose' => 'For application purposes',
                'status' => 'pending',
                'reference_number' => 'REF123',
                'dependent_id' => null,
            ],
            [
                'user_id' => $residentUsers->first()->id,
                'document_type_id' => 2,
                'purpose' => 'For employment requirements',
                'status' => 'processing',
                'reference_number' => 'REF124',
                'dependent_id' => null,
            ],
            [
                'user_id' => $residentUsers->first()->id,
                'document_type_id' => 3,
                'purpose' => 'For assistance programs',
                'status' => 'ready_for_pickup',
                'reference_number' => 'REF125',
                'dependent_id' => null,
            ],
            [
                'user_id' => $residentUsers->first()->id,
                'document_type_id' => 1,
                'purpose' => 'For travel purposes',
                'status' => 'completed',
                'reference_number' => 'REF126',
                'dependent_id' => null,
            ],
        ];

        foreach ($testRequests as $index => $requestData) {
            $request = DocumentRequest::create($requestData);

            // Create status history
            RequestStatusHistory::create([
                'document_request_id' => $request->id,
                'previous_status' => null,
                'new_status' => 'pending',
                'changed_by' => $staffUsers->first()->id ?? 1,
                'notes' => 'Request submitted',
            ]);

            // Add additional status history if not pending
            if ($requestData['status'] !== 'pending') {
                RequestStatusHistory::create([
                    'document_request_id' => $request->id,
                    'previous_status' => 'pending',
                    'new_status' => $requestData['status'],
                    'changed_by' => $staffUsers->first()->id ?? 1,
                    'notes' => 'Status updated by staff',
                ]);
            }
        }
    }
}
