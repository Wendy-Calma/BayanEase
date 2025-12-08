@extends('layouts.staff')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-4" style="color: #2d3748; font-weight: 600;">Document Request Queue</h2>
            
            <!-- Search Bar -->
            <form method="GET" action="{{ route('staff.requests') }}" class="mb-4">
                <div class="input-group" style="max-width: 600px;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or document type" class="form-control" style="border-radius: 4px 0 0 4px; border: 1px solid #e2e8f0; padding: 10px 15px;" />
                    <button class="btn" type="submit" style="background-color: #f0f0f0; border: 1px solid #e2e8f0; border-radius: 0 4px 4px 0; padding: 10px 20px; color: #718096;">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Requests Table -->
    <div class="card" style="border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead style="background-color: #f8f9fa; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th style="color: #2d3748; font-weight: 600; padding: 15px;">Reference No:</th>
                        <th style="color: #2d3748; font-weight: 600; padding: 15px;">Resident Name</th>
                        <th style="color: #2d3748; font-weight: 600; padding: 15px;">Document Type</th>
                        <th style="color: #2d3748; font-weight: 600; padding: 15px;">Status</th>
                        <th style="color: #2d3748; font-weight: 600; padding: 15px;">Staff</th>
                        <th style="color: #2d3748; font-weight: 600; padding: 15px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $req)
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="color: #2d3748; font-weight: 600; padding: 12px 15px;">{{ $req->reference_number }}</td>
                        <td style="color: #2d3748; padding: 12px 15px;">
                            {{ $req->user->first_name ?? '' }} {{ $req->user->last_name ?? '' }}
                        </td>
                        <td style="color: #2d3748; padding: 12px 15px;">
                            {{ $req->documentType->name ?? 'N/A' }}
                        </td>
                        <td style="padding: 12px 15px;">
                            @php
                                $statusColor = match($req->status ?? '') {
                                    'pending' => '#ff8c42',
                                    'processing' => '#4a90e2',
                                    'ready_for_pickup' => '#27ae60',
                                    'completed' => '#95a5a6',
                                    'rejected' => '#e74c3c',
                                    default => '#95a5a6'
                                };
                                $statusText = ucfirst(str_replace('_', ' ', $req->status));
                            @endphp
                            <span class="badge" style="background-color: {{ $statusColor }}; color: white; padding: 6px 12px; font-size: 12px; font-weight: 500; border-radius: 4px;">
                                <i class="fas fa-circle" style="font-size: 8px; margin-right: 4px;"></i>
                                {{ $statusText }}
                            </span>
                        </td>
                        <td style="color: #2d3748; padding: 12px 15px;">
                            @if($req->assigned_to)
                                {{ $req->assignedStaff->first_name ?? '' }} {{ $req->assignedStaff->last_name ?? '' }}
                            @else
                                <span style="color: #a0aec0;">Unassigned</span>
                            @endif
                        </td>
                        <td style="padding: 12px 15px;">
                            <div class="btn-group" role="group">
                                @if($req->status == 'pending')
                                    <button type="button" class="btn btn-sm btn-success" style="background-color: #27ae60; border: none; color: white; padding: 6px 12px; margin-right: 4px; font-weight: 600; border-radius: 4px;" onclick="showConfirmModal({{ $req->id }}, 'processing', 'Approve this request?', 'This will move the request to processing status.')">
                                        Approve
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" style="background-color: #e74c3c; border: none; color: white; padding: 6px 12px; margin-right: 4px; font-weight: 600; border-radius: 4px;" onclick="rejectRequest({{ $req->id }})">
                                        Reject
                                    </button>
                                @elseif($req->status == 'processing')
                                    <button type="button" class="btn btn-sm btn-info" style="background-color: #4a90e2; border: none; color: white; padding: 6px 12px; margin-right: 4px; font-weight: 600; border-radius: 4px;" onclick="showConfirmModal({{ $req->id }}, 'ready_for_pickup', 'Mark as ready for pickup?', 'This will notify the resident that their document is ready.')">
                                        Mark Ready
                                    </button>
                                @elseif($req->status == 'ready_for_pickup')
                                    <button type="button" class="btn btn-sm" style="background-color: #34495e; border: none; color: white; padding: 6px 12px; margin-right: 4px; font-weight: 600; border-radius: 4px;" onclick="showConfirmModal({{ $req->id }}, 'completed', 'Mark as picked up?', 'This will complete the request.')">
                                        Mark as Picked Up
                                    </button>
                                @endif
                                <a href="{{ route('staff.requests.show', $req->id) }}" class="btn btn-sm btn-outline-warning" style="color: #ff6b35; border-color: #ff6b35; padding: 6px 12px; font-weight: 600; border-radius: 4px;">
                                    View
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No requests found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(isset($requests) && $requests->hasPages())
        <div class="card-footer" style="background-color: #f8f9fa; border-top: 1px solid #e2e8f0; padding: 20px;">
            <div class="d-flex justify-content-center">
                {{ $requests->links('pagination::bootstrap-4') }}
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Rejection Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 8px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
            <div class="modal-header" style="background-color: #e74c3c; color: white; border: none; padding: 20px; border-radius: 8px 8px 0 0;">
                <div style="display: flex; align-items: center; width: 100%;">
                    <i class="fas fa-times-circle" style="font-size: 24px; margin-right: 12px;"></i>
                    <h5 class="modal-title" id="rejectModalLabel" style="margin: 0; font-weight: 600;">Reject Request</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rejectForm" method="POST" style="padding: 20px;">
                @csrf
                <input type="hidden" name="status" value="rejected">
                
                <div class="form-group">
                    <label for="rejectionReason" style="font-weight: 600; color: #2d3748; margin-bottom: 8px;">Rejection Reason</label>
                    <select class="form-control" id="rejectionReason" name="rejection_reason" required style="border-radius: 4px; border: 1px solid #e2e8f0; padding: 10px 12px;">
                        <option value="">-- Select a reason --</option>
                        <option value="Incomplete documentation">Incomplete documentation</option>
                        <option value="Invalid ID provided">Invalid ID provided</option>
                        <option value="Does not meet eligibility criteria">Does not meet eligibility criteria</option>
                        <option value="Duplicate request">Duplicate request</option>
                        <option value="Insufficient information">Insufficient information</option>
                        <option value="Document no longer available">Document no longer available</option>
                        <option value="Other">Other (please specify in notes)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="adminNotes" style="font-weight: 600; color: #2d3748; margin-bottom: 8px;">Additional Notes</label>
                    <small style="color: #718096; display: block; margin-bottom: 8px;">Provide additional context for the rejection (optional)</small>
                    <textarea class="form-control" id="adminNotes" name="admin_notes" rows="4" style="border-radius: 4px; border: 1px solid #e2e8f0; padding: 10px 12px; resize: vertical;"></textarea>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="sendNotification" name="send_notification" checked>
                        <label class="form-check-label" for="sendNotification" style="color: #2d3748; margin-top: 2px;">
                            Notify resident via SMS/Email
                        </label>
                    </div>
                </div>

                <div class="modal-footer" style="border-top: 1px solid #e2e8f0; padding: 15px 0; display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="background-color: #ff9966; color: white; border: none; padding: 8px 20px; border-radius: 4px; font-weight: 600;">
                        Cancel
                    </button>
                    <button type="button" class="btn" style="background-color: #e74c3c; color: white; border: none; padding: 8px 20px; border-radius: 4px; font-weight: 600;" onclick="submitRejectForm()">
                        Confirm Rejection
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Confirmation Modal for Status Updates -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 8px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
            <div class="modal-header" style="background-color: #4a90e2; color: white; border: none; padding: 20px; border-radius: 8px 8px 0 0;">
                <div style="display: flex; align-items: center; width: 100%;">
                    <i class="fas fa-info-circle" style="font-size: 24px; margin-right: 12px;"></i>
                    <h5 class="modal-title" id="confirmModalLabel" style="margin: 0; font-weight: 600;">Confirm Action</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div style="padding: 20px;">
                <p id="confirmModalMessage" style="color: #2d3748; margin-bottom: 10px;"></p>
                <p id="confirmModalDescription" style="color: #718096; font-size: 14px; margin-bottom: 0;"></p>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #e2e8f0; padding: 15px 20px; display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="btn" data-bs-dismiss="modal" style="background-color: #e2e8f0; color: #2d3748; border: none; padding: 8px 20px; border-radius: 4px; font-weight: 600;">
                    Cancel
                </button>
                <button type="button" class="btn" style="background-color: #4a90e2; color: white; border: none; padding: 8px 20px; border-radius: 4px; font-weight: 600;" onclick="submitStatusUpdate()">
                    Confirm
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
let currentRejectRequestId = null;
let currentStatusUpdateId = null;
let currentStatusUpdateValue = null;

function showConfirmModal(requestId, newStatus, message, description) {
    currentStatusUpdateId = requestId;
    currentStatusUpdateValue = newStatus;
    document.getElementById('confirmModalMessage').textContent = message;
    document.getElementById('confirmModalDescription').textContent = description;
    
    const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
    modal.show();
}

function submitStatusUpdate() {
    if (!currentStatusUpdateId || !currentStatusUpdateValue) {
        alert('Error: Missing request ID or status');
        return;
    }

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/staff/requests/${currentStatusUpdateId}`;
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (csrfToken) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = '_token';
        input.value = csrfToken.getAttribute('content');
        form.appendChild(input);
    }
    
    const statusInput = document.createElement('input');
    statusInput.type = 'hidden';
    statusInput.name = 'status';
    statusInput.value = currentStatusUpdateValue;
    form.appendChild(statusInput);
    
    document.body.appendChild(form);
    form.submit();
}

function rejectRequest(requestId) {
    currentRejectRequestId = requestId;
    document.getElementById('rejectionReason').value = '';
    document.getElementById('adminNotes').value = '';
    document.getElementById('sendNotification').checked = true;
    
    const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
    modal.show();
}

function submitRejectForm() {
    const rejectionReason = document.getElementById('rejectionReason').value;
    
    if (!rejectionReason) {
        alert('Please select a rejection reason');
        return;
    }

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/staff/requests/${currentRejectRequestId}`;
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (csrfToken) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = '_token';
        input.value = csrfToken.getAttribute('content');
        form.appendChild(input);
    }
    
    const statusInput = document.createElement('input');
    statusInput.type = 'hidden';
    statusInput.name = 'status';
    statusInput.value = 'rejected';
    form.appendChild(statusInput);
    
    const reasonInput = document.createElement('input');
    reasonInput.type = 'hidden';
    reasonInput.name = 'rejection_reason';
    reasonInput.value = rejectionReason;
    form.appendChild(reasonInput);
    
    const notesInput = document.createElement('input');
    notesInput.type = 'hidden';
    notesInput.name = 'admin_notes';
    notesInput.value = document.getElementById('adminNotes').value;
    form.appendChild(notesInput);
    
    const notificationInput = document.createElement('input');
    notificationInput.type = 'hidden';
    notificationInput.name = 'send_notification';
    notificationInput.value = document.getElementById('sendNotification').checked ? 1 : 0;
    form.appendChild(notificationInput);
    
    document.body.appendChild(form);
    form.submit();
}
</script>
@endsection

