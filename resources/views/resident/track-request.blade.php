@extends('layouts.resident')

@section('title', 'Track Requests')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">My Request History</h1>

            <!-- Search Bar -->
            <div class="mb-4">
                <form method="GET" action="{{ route('request.track') }}" class="d-flex">
                    <input type="text" name="search" class="form-control" placeholder="Search by name or reference No." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-secondary ms-2">Search</button>
                </form>
            </div>

            <!-- Requests Table -->
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #f8f9fa;">
                            <tr>
                                <th style="font-weight: 600; color: #2d3748;">Reference No:</th>
                                <th style="font-weight: 600; color: #2d3748;">Document Type</th>
                                <th style="font-weight: 600; color: #2d3748;">Dependent</th>
                                <th style="font-weight: 600; color: #2d3748;">Date</th>
                                <th style="font-weight: 600; color: #2d3748;">Status Progress</th>
                                <th style="font-weight: 600; color: #2d3748;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $request)
                                <tr>
                                    <td style="color: #2d3748; font-weight: 500;">{{ $request->reference_number }}</td>
                                    <td style="color: #2d3748;">
                                        {{ $request->documentType->name ?? 'N/A' }}
                                    </td>
                                    <td style="color: #2d3748;">
                                        @if($request->dependent_id)
                                            @php
                                                $dependent = \App\Models\Dependent::find($request->dependent_id);
                                            @endphp
                                            @if($dependent)
                                                <span class="badge" style="background-color: #e6f7ff; color: #0066cc; padding: 6px 12px;">
                                                    <i class="fas fa-user"></i> {{ $dependent->first_name }} {{ $dependent->last_name }}
                                                </span>
                                            @else
                                                <span style="color: #a0aec0;">-</span>
                                            @endif
                                        @else
                                            <span style="color: #a0aec0;">Self</span>
                                        @endif
                                    </td>
                                    <td style="color: #2d3748;">
                                        {{ $request->created_at ? $request->created_at->format('Y-m-d') : 'N/A' }}
                                    </td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 8px; font-size: 12px;">
                                            <!-- Submitted -->
                                            <div style="text-align: center;">
                                                <div style="width: 28px; height: 28px; border-radius: 50%; background-color: #27ae60; color: white; display: flex; align-items: center; justify-content: center; margin: 0 auto 4px;">
                                                    <i class="fas fa-check" style="font-size: 12px;"></i>
                                                </div>
                                                <small style="color: #718096; white-space: nowrap;">Submitted</small>
                                            </div>

                                            <!-- Line -->
                                            <div style="flex: 1; height: 2px; background-color: @php
                                                echo in_array($request->status, ['processing', 'ready_for_pickup', 'completed']) ? '#ff8c42' : '#cbd5e0';
                                            @endphp;"></div>

                                            <!-- Processing -->
                                            <div style="text-align: center;">
                                                <div style="width: 28px; height: 28px; border-radius: 50%; background-color: @php
                                                    echo in_array($request->status, ['processing', 'ready_for_pickup', 'completed']) ? '#ff8c42' : '#cbd5e0';
                                                @endphp; color: white; display: flex; align-items: center; justify-content: center; margin: 0 auto 4px;">
                                                    <i class="fas fa-@php echo in_array($request->status, ['processing', 'ready_for_pickup', 'completed']) ? 'spinner' : 'hourglass-half'; @endphp" style="font-size: 12px;"></i>
                                                </div>
                                                <small style="color: #718096; white-space: nowrap;">Processing</small>
                                            </div>

                                            <!-- Line -->
                                            <div style="flex: 1; height: 2px; background-color: @php
                                                echo in_array($request->status, ['ready_for_pickup', 'completed']) ? '#ff8c42' : '#cbd5e0';
                                            @endphp;"></div>

                                            <!-- Ready -->
                                            <div style="text-align: center;">
                                                <div style="width: 28px; height: 28px; border-radius: 50%; background-color: @php
                                                    echo in_array($request->status, ['ready_for_pickup', 'completed']) ? '#ff8c42' : '#cbd5e0';
                                                @endphp; color: white; display: flex; align-items: center; justify-content: center; margin: 0 auto 4px;">
                                                    <i class="fas fa-check" style="font-size: 12px;"></i>
                                                </div>
                                                <small style="color: #718096; white-space: nowrap;">Ready</small>
                                            </div>

                                            <!-- Line -->
                                            <div style="flex: 1; height: 2px; background-color: @php
                                                echo $request->status === 'completed' ? '#27ae60' : '#cbd5e0';
                                            @endphp;"></div>

                                            <!-- Completed -->
                                            <div style="text-align: center;">
                                                <div style="width: 28px; height: 28px; border-radius: 50%; background-color: @php
                                                    echo $request->status === 'completed' ? '#27ae60' : '#cbd5e0';
                                                @endphp; color: white; display: flex; align-items: center; justify-content: center; margin: 0 auto 4px;">
                                                    <i class="fas fa-check" style="font-size: 12px;"></i>
                                                </div>
                                                <small style="color: #718096; white-space: nowrap;">Completed</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('request.track.show', $request->id) }}" class="btn btn-sm btn-outline-warning" style="color: #ff6b35; border-color: #ff6b35; font-weight: 600;">
                                            View
                                        </a>
                                        @if($request->status == 'completed')
                                            <a href="#" class="btn btn-sm btn-success" style="font-weight: 600;">
                                                Download Copy
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        You have no requests yet. <a href="{{ route('document.request') }}" style="color: #ff6b35; text-decoration: none;">Create one now</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if(isset($requests) && $requests->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $requests->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
