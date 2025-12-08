<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\DocumentRequest;
use App\Models\User;
use App\Models\RequestStatusHistory;
use App\Models\Notification;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RequestController extends Controller
{
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function index(Request $request)
    {
        $search = $request->get('search');
        $query = DocumentRequest::with(['user', 'documentType', 'assignedStaff']);
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('reference_number', 'like', "%$search%")
                   ->orWhereHas('user', function($u) use ($search) {
                       $u->where('first_name', 'like', "%$search%")
                         ->orWhere('last_name', 'like', "%$search%");
                   })
                   ->orWhereHas('documentType', function($d) use ($search) {
                       $d->where('name', 'like', "%$search%");
                   });
            });
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('staff.request-queue', compact('requests'));
    }

    public function show($id)
    {
        $request = DocumentRequest::with(['user', 'documentType', 'statusHistory', 'uploadedDocuments'])->findOrFail($id);
        $staffMembers = User::whereHas('role', function($q) {
            $q->where('name', 'staff');
        })->get();
        
        return view('staff.request-show', compact('request', 'staffMembers'));
    }

    public function update(Request $request, $id)
    {
        $documentRequest = DocumentRequest::with('user', 'documentType')->findOrFail($id);
        $oldStatus = $documentRequest->status;
        $newStatus = $request->input('status', $oldStatus);
        
        // Update request status
        $documentRequest->status = $newStatus;
        $documentRequest->assigned_to = $request->input('assigned_to', $documentRequest->assigned_to);
        
        // Handle rejection
        if ($newStatus === 'rejected') {
            $documentRequest->rejection_reason = $request->input('rejection_reason');
            $documentRequest->admin_notes = $request->input('admin_notes');
            $documentRequest->rejected_at = now();
        }
        
        // Handle ready for pickup
        if ($newStatus === 'ready_for_pickup') {
            $documentRequest->ready_at = now();
        }
        
        // Handle completed
        if ($newStatus === 'completed') {
            $documentRequest->completed_at = now();
        }
        
        // Handle processing
        if ($newStatus === 'processing' && !$documentRequest->processing_started_at) {
            $documentRequest->processing_started_at = now();
        }
        
        $documentRequest->save();

        // Create status history entry
        RequestStatusHistory::create([
            'document_request_id' => $documentRequest->id,
            'previous_status' => $oldStatus,
            'new_status' => $newStatus,
            'changed_by' => auth()->id(),
            'notes' => $newStatus === 'rejected' ? ($request->input('rejection_reason') ?? 'Request rejected') : "Status changed from {$oldStatus} to {$newStatus}",
        ]);

        // Create notification for the user
        $statusMessages = [
            'processing' => 'Your request is now being processed',
            'ready_for_pickup' => 'Your document is ready for pickup!',
            'completed' => 'Your request has been completed',
            'rejected' => 'Your request has been rejected. Reason: ' . ($request->input('rejection_reason') ?? 'No reason provided'),
        ];

        Notification::create([
            'user_id' => $documentRequest->user_id,
            'title' => $newStatus === 'rejected' ? 'Request Rejected' : 'Request Status Updated',
            'message' => $statusMessages[$newStatus] ?? "Your request status has been updated to {$newStatus}",
            'type' => $newStatus === 'rejected' ? 'request_rejected' : 'status_changed',
            'related_id' => $documentRequest->id,
            'is_read' => false,
        ]);

        // Send SMS if checkbox is checked and user has phone number
        $smsSent = false;
        if ($request->input('send_sms') && $documentRequest->user && $documentRequest->user->phone_number) {
            try {
                $smsSent = $this->smsService->sendDocumentStatusUpdate(
                    $documentRequest->user,
                    $documentRequest,
                    $newStatus
                );

                if ($smsSent) {
                    Log::info('SMS sent successfully', [
                        'user_id' => $documentRequest->user_id,
                        'phone' => $documentRequest->user->phone_number,
                        'status' => $newStatus
                    ]);
                } else {
                    Log::warning('SMS sending failed', [
                        'user_id' => $documentRequest->user_id,
                        'phone' => $documentRequest->user->phone_number
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('SMS sending exception', [
                    'error' => $e->getMessage(),
                    'user_id' => $documentRequest->user_id
                ]);
            }
        }

        // Return with appropriate message
        if ($smsSent) {
            return back()->with('success', 'Request updated successfully and SMS notification sent!');
        } elseif ($request->input('send_sms') && !$documentRequest->user->phone_number) {
            return back()->with('warning', 'Request updated but SMS not sent - no phone number on record.');
        } elseif ($request->input('send_sms')) {
            return back()->with('warning', 'Request updated but SMS sending failed. Check SMS service logs.');
        }

        return back()->with('success', 'Request updated successfully');
    }
}