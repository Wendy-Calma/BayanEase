<?php

namespace App\Http\Controllers;

use App\Models\DocumentRequest;
use App\Models\RequestStatusHistory;
use App\Models\Notification;
use Illuminate\Http\Request;

class RequestTrackingController extends Controller
{
    public function index()
    {
        $requests = DocumentRequest::where('user_id', auth()->id())
            ->with(['documentType', 'statusHistory'])
            ->latest()
            ->paginate(10);

        return view('resident.track-request', compact('requests'));
    }

    public function show(DocumentRequest $request)
    {
        if ($request->user_id !== auth()->id()) {
            abort(403);
        }

        $request->load(['documentType', 'statusHistory', 'uploadedDocuments']);
        
        return view('resident.track-request-details', compact('request'));
    }

    public function cancel(DocumentRequest $request)
    {
        if ($request->user_id !== auth()->id()) {
            abort(403);
        }

        // Only allow cancelling pending or processing requests
        if (!in_array($request->status, ['pending', 'processing'])) {
            return back()->withErrors(['error' => 'This request cannot be cancelled at this stage.']);
        }

        // Update the request status to cancelled
        $oldStatus = $request->status;
        $request->update(['status' => 'cancelled', 'cancelled_at' => now()]);

        // Create status history entry
        RequestStatusHistory::create([
            'document_request_id' => $request->id,
            'previous_status' => $oldStatus,
            'new_status' => 'cancelled',
            'changed_by' => auth()->id(),
            'notes' => 'Request cancelled by resident',
        ]);

        // Create notification for the user
        Notification::create([
            'user_id' => auth()->id(),
            'title' => 'Request Cancelled',
            'message' => "Your document request (Reference: {$request->reference_number}) has been cancelled.",
            'type' => 'request_cancelled',
            'related_id' => $request->id,
            'is_read' => false,
        ]);

        return back()->with('success', 'Request cancelled successfully.');
    }
}