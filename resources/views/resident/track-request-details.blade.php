@extends('layouts.resident')

@section('title', 'Request Details - ' . $request->reference_number)

@section('content')
<div class="container-fluid py-5">
    <div class="row">
        <div class="col-12">
            <!-- Back Button -->
            <a href="{{ route('request.track') }}" class="btn btn-outline-secondary mb-4">
                <i class="fas fa-arrow-left"></i> Back to Requests
            </a>

            <!-- Main Request Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header" style="background: linear-gradient(135deg, #ff8c42 0%, #ff6b35 100%); color: white; border: none;">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-1">Request Details</h3>
                            <p class="mb-0" style="opacity: 0.9;">Reference: <strong>{{ $request->reference_number }}</strong></p>
                        </div>
                        <div class="col-auto">
                            @php
                                $statusColors = [
                                    'pending' => ['bg' => '#ff8c42', 'text' => 'Pending'],
                                    'processing' => ['bg' => '#4a90e2', 'text' => 'Processing'],
                                    'ready_for_pickup' => ['bg' => '#27ae60', 'text' => 'Ready for Pickup'],
                                    'completed' => ['bg' => '#34495e', 'text' => 'Completed'],
                                    'rejected' => ['bg' => '#e74c3c', 'text' => 'Rejected'],
                                    'cancelled' => ['bg' => '#95a5a6', 'text' => 'Cancelled'],
                                ];
                                $statusInfo = $statusColors[$request->status] ?? ['bg' => '#95a5a6', 'text' => ucfirst(str_replace('_', ' ', $request->status))];
                            @endphp
                            <span class="badge" style="background-color: {{ $statusInfo['bg'] }}; padding: 10px 20px; font-size: 14px; font-weight: 600;">
                                {{ $statusInfo['text'] }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 style="color: #2d3748; font-weight: 600; margin-bottom: 15px;">Request Information</h5>
                            
                            <div class="mb-3">
                                <label style="color: #718096; font-weight: 600; font-size: 12px; text-transform: uppercase;">Document Type</label>
                                <p style="color: #2d3748; font-size: 16px;">
                                    <i class="fas fa-file-alt" style="color: #667eea; margin-right: 8px;"></i>
                                    {{ $request->documentType->name ?? 'N/A' }}
                                </p>
                            </div>

                            <div class="mb-3">
                                <label style="color: #718096; font-weight: 600; font-size: 12px; text-transform: uppercase;">Purpose</label>
                                <p style="color: #2d3748; font-size: 14px; line-height: 1.6;">
                                    {{ $request->purpose ?? 'Not specified' }}
                                </p>
                            </div>

                            <div class="mb-3">
                                <label style="color: #718096; font-weight: 600; font-size: 12px; text-transform: uppercase;">Submitted Date</label>
                                <p style="color: #2d3748; font-size: 14px;">
                                    <i class="fas fa-calendar" style="color: #667eea; margin-right: 8px;"></i>
                                    {{ $request->created_at ? $request->created_at->format('F d, Y \a\t h:i A') : 'N/A' }}
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h5 style="color: #2d3748; font-weight: 600; margin-bottom: 15px;">Additional Information</h5>
                            
                            <div class="mb-3">
                                <label style="color: #718096; font-weight: 600; font-size: 12px; text-transform: uppercase;">Priority</label>
                                <p style="color: #2d3748; font-size: 14px;">
                                    @php
                                        $priorityColors = [
                                            'low' => '#27ae60',
                                            'normal' => '#4a90e2',
                                            'high' => '#e74c3c',
                                        ];
                                        $priorityColor = $priorityColors[$request->priority] ?? '#95a5a6';
                                    @endphp
                                    <span class="badge" style="background-color: {{ $priorityColor }}; padding: 4px 8px;">
                                        {{ ucfirst($request->priority ?? 'normal') }}
                                    </span>
                                </p>
                            </div>

                            @if($request->preferred_pickup_date)
                                <div class="mb-3">
                                    <label style="color: #718096; font-weight: 600; font-size: 12px; text-transform: uppercase;">Preferred Pickup Date</label>
                                    <p style="color: #2d3748; font-size: 14px;">
                                        <i class="fas fa-calendar-check" style="color: #667eea; margin-right: 8px;"></i>
                                        {{ \Carbon\Carbon::parse($request->preferred_pickup_date)->format('F d, Y') }}
                                    </p>
                                </div>
                            @endif

                            @if($request->contact_number)
                                <div class="mb-3">
                                    <label style="color: #718096; font-weight: 600; font-size: 12px; text-transform: uppercase;">Contact Number</label>
                                    <p style="color: #2d3748; font-size: 14px;">
                                        <i class="fas fa-phone" style="color: #667eea; margin-right: 8px;"></i>
                                        {{ $request->contact_number }}
                                    </p>
                                </div>
                            @endif

                            @if($request->documentType)
                                <div class="mb-3">
                                    <label style="color: #718096; font-weight: 600; font-size: 12px; text-transform: uppercase;">Processing Time</label>
                                    <p style="color: #2d3748; font-size: 14px;">
                                        <i class="fas fa-hourglass-half" style="color: #667eea; margin-right: 8px;"></i>
                                        {{ $request->documentType->processing_days ?? 'N/A' }} days
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($request->special_instructions)
                        <div class="alert alert-info mb-0">
                            <h6 style="font-weight: 600; margin-bottom: 8px;">
                                <i class="fas fa-lightbulb"></i> Special Instructions
                            </h6>
                            <p style="margin-bottom: 0;">{{ $request->special_instructions }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Status Timeline -->
            <div class="card shadow-sm mb-4">
                <div class="card-header" style="background-color: #f8f9fa; border-bottom: 2px solid #e2e8f0;">
                    <h5 style="color: #2d3748; font-weight: 600; margin-bottom: 0;">Request Status Timeline</h5>
                </div>
                <div class="card-body">
                    @if($request->statusHistory && $request->statusHistory->count() > 0)
                        <div style="position: relative; padding: 20px 0;">
                            @foreach($request->statusHistory as $index => $history)
                                <div style="display: flex; margin-bottom: {{ $index === $request->statusHistory->count() - 1 ? '0' : '30px' }};">
                                    <!-- Timeline Dot -->
                                    <div style="position: relative; margin-right: 20px; text-align: center;">
                                        <div style="
                                            width: 40px;
                                            height: 40px;
                                            border-radius: 50%;
                                            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            color: white;
                                            font-weight: bold;
                                            z-index: 2;
                                        ">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        @if($index !== $request->statusHistory->count() - 1)
                                            <div style="
                                                width: 2px;
                                                height: 30px;
                                                background: #e2e8f0;
                                                position: absolute;
                                                top: 40px;
                                                left: 50%;
                                                transform: translateX(-50%);
                                            "></div>
                                        @endif
                                    </div>

                                    <!-- Timeline Content -->
                                    <div style="flex: 1; padding-top: 5px;">
                                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 5px;">
                                            <h6 style="color: #2d3748; font-weight: 600; margin-bottom: 0;">
                                                {{ ucfirst(str_replace('_', ' ', $history->new_status)) }}
                                            </h6>
                                            <small style="color: #718096;">
                                                {{ $history->created_at ? $history->created_at->format('M d, Y \a\t h:i A') : 'N/A' }}
                                            </small>
                                        </div>

                                        @if($history->notes)
                                            <p style="color: #718096; margin-bottom: 0; font-size: 14px;">
                                                {{ $history->notes }}
                                            </p>
                                        @endif

                                        @if($history->previous_status)
                                            <small style="color: #a0aec0;">
                                                Previous: {{ ucfirst(str_replace('_', ' ', $history->previous_status)) }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center py-4">
                            No status history available yet.
                        </p>
                    @endif
                </div>
            </div>

            <!-- Admin Notes Section -->
            @if($request->admin_notes)
                <div class="card shadow-sm mb-4">
                    <div class="card-header" style="background-color: #fef5e7; border-bottom: 2px solid #f9e79f;">
                        <h5 style="color: #d68910; font-weight: 600; margin-bottom: 0;">
                            <i class="fas fa-sticky-note"></i> Notes from Staff
                        </h5>
                    </div>
                    <div class="card-body">
                        <p style="color: #2d3748; line-height: 1.6; margin-bottom: 0;">
                            {{ $request->admin_notes }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Rejection Reason (if applicable) -->
            @if($request->status === 'rejected' && $request->rejection_reason)
                <div class="card shadow-sm mb-4" style="border-left: 4px solid #e74c3c;">
                    <div class="card-header" style="background-color: #fadbd8; border-bottom: 2px solid #f5b7b1;">
                        <h5 style="color: #c0392b; font-weight: 600; margin-bottom: 0;">
                            <i class="fas fa-times-circle"></i> Rejection Reason
                        </h5>
                    </div>
                    <div class="card-body">
                        <p style="color: #2d3748; line-height: 1.6; margin-bottom: 0;">
                            {{ $request->rejection_reason }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Uploaded Documents -->
            @if($request->uploadedDocuments && $request->uploadedDocuments->count() > 0)
                <div class="card shadow-sm mb-4">
                    <div class="card-header" style="background-color: #f8f9fa; border-bottom: 2px solid #e2e8f0;">
                        <h5 style="color: #2d3748; font-weight: 600; margin-bottom: 0;">
                            <i class="fas fa-file-upload"></i> Attached Documents
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead style="background-color: #edf2f7;">
                                    <tr>
                                        <th style="font-weight: 600; color: #2d3748;">File Name</th>
                                        <th style="font-weight: 600; color: #2d3748;">Size</th>
                                        <th style="font-weight: 600; color: #2d3748;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($request->uploadedDocuments as $document)
                                        <tr>
                                            <td style="color: #2d3748;">
                                                <i class="fas fa-file" style="color: #667eea; margin-right: 8px;"></i>
                                                {{ $document->original_name }}
                                            </td>
                                            <td style="color: #718096;">
                                                {{ number_format($document->file_size / 1024, 2) }} KB
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="d-flex gap-2 mb-4">
                @if($request->status === 'completed')
                    <button class="btn btn-success" style="font-weight: 600;">
                        <i class="fas fa-download"></i> Download Document
                    </button>
                @endif

                @if($request->status === 'rejected')
                    <a href="{{ route('document.request') }}" class="btn btn-primary" style="font-weight: 600;">
                        <i class="fas fa-plus"></i> Submit New Request
                    </a>
                @endif

                @if(in_array($request->status, ['pending', 'processing']))
                    <button class="btn btn-danger" style="font-weight: 600;" onclick="cancelRequest({{ $request->id }})">
                        <i class="fas fa-times"></i> Cancel Request
                    </button>
                @endif

                <a href="{{ route('request.track') }}" class="btn btn-outline-secondary" style="font-weight: 600;">
                    <i class="fas fa-arrow-left"></i> Back to Requests
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function cancelRequest(requestId) {
    if (confirm('Are you sure you want to cancel this request?')) {
        // Create a form to submit the cancel request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/request/${requestId}/cancel`;
        
        // Add CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (csrfToken) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = '_token';
            input.value = csrfToken.getAttribute('content');
            form.appendChild(input);
        }
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

<style>
    .card {
        border: none;
        border-radius: 8px;
    }

    .card-header {
        border-radius: 8px 8px 0 0;
    }

    .btn {
        border-radius: 6px;
        padding: 8px 16px;
        font-size: 14px;
    }

    .badge {
        border-radius: 4px;
    }

    .table {
        border-collapse: collapse;
    }

    .table tbody tr:hover {
        background-color: #f7fafc;
    }
</style>
@endsection
