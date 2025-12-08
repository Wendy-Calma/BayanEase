@extends('layouts.staff')

@section('content')
<div class="container-fluid" style="max-width:900px;">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4" style="font-weight:700;">Welcome back, {{ auth()->user()->first_name }}!</h2>
            <div class="row mb-4" style="gap: 0.5rem 0;">
                <div class="col-md-3 mb-3">
                    <div style="background:#FA812F; color:#fff; border-radius:8px; padding:1.5rem 0; text-align:center; font-weight:600; font-size:1.5rem;">
                        {{ $stats['pending_requests'] }}
                        <div style="font-size:1rem; font-weight:400; margin-top:0.5rem;">Pending</div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div style="background:#2386F6; color:#fff; border-radius:8px; padding:1.5rem 0; text-align:center; font-weight:600; font-size:1.5rem;">
                        {{ $stats['processing_requests'] }}
                        <div style="font-size:1rem; font-weight:400; margin-top:0.5rem;">Processing</div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div style="background:#20B573; color:#fff; border-radius:8px; padding:1.5rem 0; text-align:center; font-weight:600; font-size:1.5rem;">
                        {{ $stats['assigned_requests'] }}
                        <div style="font-size:1rem; font-weight:400; margin-top:0.5rem;">Assigned</div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div style="background:#27ae60; color:#fff; border-radius:8px; padding:1.5rem 0; text-align:center; font-weight:600; font-size:1.5rem;">
                        {{ $stats['completed_requests'] }}
                        <div style="font-size:1rem; font-weight:400; margin-top:0.5rem;">Completed</div>
                    </div>
                </div>
            </div>
            <div class="card" style="border-radius:8px;">
                <div class="card-body">
                    <h5 class="mb-3" style="font-weight:600;">Recent Assigned Requests</h5>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Reference No</th>
                                    <th>Resident Name</th>
                                    <th>Document</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_requests as $request)
                                <tr>
                                    <td><strong>{{ $request->reference_number }}</strong></td>
                                    <td>{{ $request->user->first_name ?? 'N/A' }} {{ $request->user->last_name ?? '' }}</td>
                                    <td>{{ $request->documentType->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($request->status === 'pending')
                                            <span class="badge" style="background:#ff8c42;">Pending</span>
                                        @elseif($request->status === 'processing')
                                            <span class="badge" style="background:#4a90e2;">Processing</span>
                                        @elseif($request->status === 'ready_for_pickup')
                                            <span class="badge" style="background:#27ae60;">Ready</span>
                                        @elseif($request->status === 'completed')
                                            <span class="badge" style="background:#95a5a6;">Completed</span>
                                        @else
                                            <span class="badge" style="background:#e74c3c;">{{ ucfirst($request->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('staff.requests.show', $request->id) }}" class="btn btn-sm" style="background:#FA812F; color:#fff; font-weight:600; border-radius:6px; padding:0.25rem 0.75rem; font-size:0.9rem;">View</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No assigned requests yet</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 text-end">
                        <a href="{{ route('staff.requests') }}" class="btn" style="background:#FA812F; color:#fff; font-weight:600; border-radius:6px; padding:0.5rem 1.5rem;">View All Requests</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection