@extends('layouts.staff')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="mb-4" style="font-weight: 600; color: #2d3748;">Resident Verification (Quick Search)</h2>
        <p class="text-muted">Use the search box below to find a resident by name or reference number to verify their identity upon document pickup, or to check their active request.</p>
    </div>
</div>

<div class="card" style="border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-radius: 8px;">
    <div class="card-body">
        <form method="GET" action="{{ route('staff.resident.search') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Enter Resident Name or Reference No." class="form-control" style="border-radius: 4px 0 0 4px; border: 1px solid #e2e8f0; padding: 10px 15px;" />
                <button class="btn btn-primary" type="submit" style="background-color: #2563eb; border: none; color: white; border-radius: 0 4px 4px 0; padding: 10px 20px; font-weight: 600;">Search</button>
            </div>
        </form>

        @if(!request('q'))
            <div class="alert alert-info" style="background-color: #cce5ff; border: 1px solid #99ccff; color: #003d99; border-radius: 4px; padding: 12px;">
                Use the search box above to find a resident and verify their identity.
            </div>
        @elseif($residents->isEmpty())
            <div class="alert alert-warning" style="background-color: #fff3cd; border: 1px solid #ffc107; color: #856404; border-radius: 4px; padding: 12px;">
                No residents found matching "{{ request('q') }}". Please try a different search term.
            </div>
        @else
            <div class="row">
                @foreach($residents as $resident)
                <div class="col-12 mb-4">
                    <div class="card" style="border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;">
                        <div class="card-header" style="background-color: #f8f9fa; padding: 15px; border-bottom: 1px solid #e2e8f0;">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 style="margin: 0; font-weight: 600; color: #2d3748;">
                                        {{ $resident->first_name }} {{ $resident->surname ?? $resident->last_name }}
                                    </h5>
                                    <small style="color: #718096;">
                                        <strong>Phone:</strong> {{ $resident->phone_number ?? 'N/A' }}<br>
                                        <strong>Address:</strong> {{ $resident->complete_address ?? 'N/A' }}
                                    </small>
                                </div>
                                <div class="col-md-6 text-right">
                                    <small style="color: #718096;">
                                        <strong>Gender:</strong> {{ ucfirst($resident->gender ?? 'N/A') }}<br>
                                        <strong>Civil Status:</strong> {{ ucfirst($resident->civil_status ?? 'N/A') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 style="font-weight: 600; color: #2d3748; margin-bottom: 15px;">Active Requests</h6>
                            
                            @if($resident->documentRequests->isEmpty())
                                <p class="text-muted">No active requests</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-sm mb-0">
                                        <thead style="background-color: #f8f9fa;">
                                            <tr>
                                                <th style="color: #2d3748; font-weight: 600;">Reference No</th>
                                                <th style="color: #2d3748; font-weight: 600;">Document Type</th>
                                                <th style="color: #2d3748; font-weight: 600;">Status</th>
                                                <th style="color: #2d3748; font-weight: 600;">Submitted</th>
                                                <th style="color: #2d3748; font-weight: 600;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($resident->documentRequests as $request)
                                            <tr>
                                                <td style="color: #2d3748; font-weight: 600;">{{ $request->reference_number }}</td>
                                                <td style="color: #2d3748;">{{ $request->documentType->name ?? 'N/A' }}</td>
                                                <td>
                                                    @php
                                                        $statusColor = match($request->status ?? '') {
                                                            'pending' => '#ff8c42',
                                                            'processing' => '#4a90e2',
                                                            'ready_for_pickup' => '#27ae60',
                                                            'completed' => '#95a5a6',
                                                            'rejected' => '#e74c3c',
                                                            default => '#95a5a6'
                                                        };
                                                    @endphp
                                                    <span class="badge" style="background-color: {{ $statusColor }}; color: white; padding: 6px 12px; font-size: 12px; font-weight: 500; border-radius: 4px;">
                                                        {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                                    </span>
                                                </td>
                                                <td style="color: #718096; font-size: 0.9rem;">
                                                    {{ $request->created_at->format('M d, Y') }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('staff.requests.show', $request->id) }}" class="btn btn-sm" style="background-color: #ff6b35; color: white; border: none; padding: 6px 12px; border-radius: 4px; font-weight: 600; text-decoration: none; font-size: 0.9rem;">
                                                        View
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($residents->hasPages())
            <div style="margin-top: 20px; text-align: center;">
                {{ $residents->links('pagination::bootstrap-4') }}
            </div>
            @endif
        @endif
    </div>
</div>
@endsection
