<?php

namespace App\Observers;

use App\Models\DocumentRequest;
use App\Models\RequestStatusHistory;
use App\Models\Notification;

class DocumentRequestObserver
{
    /**
     * Handle the DocumentRequest "created" event.
     */
    public function created(DocumentRequest $documentRequest): void
    {
        // Create initial status history when request is created
        RequestStatusHistory::create([
            'document_request_id' => $documentRequest->id,
            'previous_status' => null,
            'new_status' => 'pending',
            'changed_by' => auth()->id() ?? $documentRequest->user_id,
            'notes' => 'Request submitted',
        ]);

        // Create notification for the user
        Notification::create([
            'user_id' => $documentRequest->user_id,
            'title' => 'Request Submitted',
            'message' => "Your document request (Reference: {$documentRequest->reference_number}) has been submitted successfully",
            'type' => 'request_submitted',
            'related_id' => $documentRequest->id,
            'is_read' => false,
        ]);
    }

    /**
     * Handle the DocumentRequest "updated" event.
     */
    public function updated(DocumentRequest $documentRequest): void
    {
        // Create status history when status changes
        if ($documentRequest->isDirty('status')) {
            $previousStatus = $documentRequest->getOriginal('status');
            $newStatus = $documentRequest->status;

            RequestStatusHistory::create([
                'document_request_id' => $documentRequest->id,
                'previous_status' => $previousStatus,
                'new_status' => $newStatus,
                'changed_by' => auth()->id() ?? null,
                'notes' => "Status changed from {$previousStatus} to {$newStatus}",
            ]);

            // Create notification for status change
            $statusMessages = [
                'pending' => 'Your request is pending',
                'processing' => 'Your request is now being processed',
                'ready_for_pickup' => 'Your document is ready for pickup',
                'completed' => 'Your request has been completed',
                'rejected' => 'Your request has been rejected',
            ];

            Notification::create([
                'user_id' => $documentRequest->user_id,
                'title' => 'Request Status Updated',
                'message' => $statusMessages[$newStatus] ?? "Your request status has been updated to {$newStatus}",
                'type' => 'status_changed',
                'related_id' => $documentRequest->id,
                'is_read' => false,
            ]);
        }
    }
}
