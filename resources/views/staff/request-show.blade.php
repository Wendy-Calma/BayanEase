@extends('layouts.staff')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="mb-4">Request REF#{{ $request->reference_number ?? '' }}</h2>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Resident Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Resident Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Name</p>
                        <p class="mb-0"><strong>{{ $request->user->first_name ?? '' }} {{ $request->user->last_name ?? '' }}</strong></p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Contact</p>
                        <p class="mb-0">{{ $request->user->phone_number ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Email</p>
                        <p class="mb-0">{{ $request->user->email ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Address</p>
                        <p class="mb-0">{{ $request->user->complete_address ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Request Details -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Request Details</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Document Type</p>
                        <p class="mb-0"><strong>{{ $request->documentType->name ?? 'N/A' }}</strong></p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Purpose</p>
                        <p class="mb-0">{{ $request->purpose ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Date Submitted</p>
                        <p class="mb-0">{{ $request->created_at ? $request->created_at->format('M d, Y - h:i A') : 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Days Pending</p>
                        <p class="mb-0">{{ isset($request->created_at) ? now()->diffInDays($request->created_at) . ' days' : '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Process Request -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Process Request</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('staff.requests.update', $request->id) }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Update Status</label>
                        <select class="form-select" name="status">
                            <option value="processing" {{ ($request->status ?? '') == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="ready_for_pickup" {{ ($request->status ?? '') == 'ready_for_pickup' ? 'selected' : '' }}>Ready for Pickup</option>
                            <option value="completed" {{ ($request->status ?? '') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Priority Level</label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="priority" id="priority_low" value="low">
                            <label class="btn btn-outline-secondary" for="priority_low">Low</label>
                            
                            <input type="radio" class="btn-check" name="priority" id="priority_normal" value="normal" checked>
                            <label class="btn btn-outline-warning" for="priority_normal">Normal</label>
                            
                            <input type="radio" class="btn-check" name="priority" id="priority_high" value="high">
                            <label class="btn btn-outline-danger" for="priority_high">High</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Assigned To</label>
                        <select class="form-select" name="assigned_to">
                            <option value="">Unassigned</option>
                            @foreach($staffMembers ?? [] as $s)
                                <option value="{{ $s->id }}" {{ ($request->assigned_to ?? '') == $s->id ? 'selected' : '' }}>{{ $s->first_name }} {{ $s->last_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="4">{{ old('notes') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Set Pickup Date</label>
                        <input type="date" name="pickup_date" class="form-control" />
                    </div>

                    <!-- SMS Notification Checkbox -->
                    <div class="mb-3">
                        <div class="card" style="border: 1px solid #e2e8f0; border-radius: 6px; background-color: #f8f9fa;">
                            <div class="card-body" style="padding: 12px 16px;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="send_sms" id="sendSms" value="1" checked style="width: 18px; height: 18px; margin-top: 2px;">
                                    <label class="form-check-label" for="sendSms" style="font-size: 14px; color: #2d3748; margin-left: 4px;">
                                        📱 Send SMS notification to resident
                                    </label>
                                </div>
                                @if(!$request->user->phone_number)
                                    <small class="text-warning d-block mt-2">
                                        ⚠️ No phone number on record. SMS cannot be sent.
                                    </small>
                                @else
                                    <small class="text-muted d-block mt-2">
                                        Will send to: {{ $request->user->phone_number }}
                                    </small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">Save & Send Update</button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 8px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
            <div class="modal-header" style="border-bottom: 1px solid #e2e8f0; background-color: #f8f9fa; border-radius: 8px 8px 0 0;">
                <h5 class="modal-title" id="rejectModalLabel" style="color: #2d3748; font-weight: 600;">
                    <i class="fas fa-times-circle" style="color: #e74c3c; margin-right: 8px;"></i>
                    Reject Request #{{ $request->reference_number }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 30px;">
                <p style="color: #718096; margin-bottom: 20px; line-height: 1.6;">
                    Please provide a reason for rejecting this document request.<br>
                    <small style="color: #a0aec0;">This will be sent to the resident.</small>
                </p>

                <form id="rejectForm" method="POST" action="{{ route('staff.requests.update', $request->id) }}">
                    @csrf
                    <input type="hidden" name="status" value="rejected">

                    <!-- Rejection Reason Dropdown -->
                    <div class="mb-4">
                        <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 14px; margin-bottom: 10px;">
                            Rejection Reason
                        </label>
                        <select class="form-select" name="rejection_reason" id="rejectionReason" required style="border: 1px solid #cbd5e0; border-radius: 6px; padding: 10px 12px; color: #2d3748;">
                            <option value="">Select a reason</option>
                            <option value="Incomplete documentation">Incomplete documentation</option>
                            <option value="Invalid ID provided">Invalid ID provided</option>
                            <option value="Does not meet eligibility criteria">Does not meet eligibility criteria</option>
                            <option value="Duplicate request">Duplicate request</option>
                            <option value="Insufficient information">Insufficient information</option>
                            <option value="Document no longer available">Document no longer available</option>
                            <option value="Other">Other - Please specify below</option>
                        </select>
                    </div>

                    <!-- Additional Notes -->
                    <div class="mb-4">
                        <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 14px; margin-bottom: 10px;">
                            Additional Notes
                        </label>
                        <textarea class="form-control" name="admin_notes" id="additionalNotes" rows="4" placeholder="Provide specific details about the rejection...&#10;Be clear and specific to help the resident understand what needs to be corrected." style="border: 1px solid #cbd5e0; border-radius: 6px; padding: 10px 12px; color: #2d3748; font-size: 14px; line-height: 1.5;"></textarea>
                        <small style="color: #a0aec0; margin-top: 6px; display: block;">
                            Be clear and specific to help the resident understand what needs to be corrected.
                        </small>
                    </div>

                    <!-- Notification Checkbox -->
                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="sendNotification" name="send_sms" value="1" checked style="width: 18px; height: 18px; border: 1px solid #cbd5e0; border-radius: 4px;">
                            <label class="form-check-label" for="sendNotification" style="color: #718096; font-size: 14px; margin-top: 2px;">
                                📱 Send SMS notification to resident about this rejection
                            </label>
                        </div>
                        @if(!$request->user->phone_number)
                            <small class="text-warning d-block mt-2" style="margin-left: 24px;">
                                ⚠️ No phone number on record. SMS cannot be sent.
                            </small>
                        @endif
                    </div>

                    <div class="modal-footer" style="border-top: 1px solid #e2e8f0; padding: 20px 0; margin-top: 20px;">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border: 1px solid #cbd5e0; color: #718096; padding: 8px 24px; border-radius: 6px; font-weight: 500;">
                            Cancel
                        </button>
                        <button type="submit" class="btn" style="background-color: #e74c3c; color: white; padding: 8px 24px; border-radius: 6px; font-weight: 600; border: none;">
                            Confirm Rejection
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection