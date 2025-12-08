@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-2">System Overview Dashboard</h1>

            <div class="stats-row">
                <div class="stat-card stat-orange">
                    <div style="font-size:28px; font-weight:700">{{ $stats['total_requests'] ?? 0 }}</div>
                    <div style="opacity:.9; margin-top:6px">Total Request<br><small style="opacity:.85">(YTD)</small></div>
                </div>

                <div class="stat-card stat-blue">
                    <div style="font-size:28px; font-weight:700">{{ $stats['active_staffs'] ?? ($stats['total_users'] ?? 0) }}</div>
                    <div style="opacity:.9; margin-top:6px">Active Barangay Staffs</div>
                </div>

                <div class="stat-card stat-green">
                    <div style="font-size:28px; font-weight:700">{{ $stats['avg_processing_hours'] !== null ? $stats['avg_processing_hours'] : '-' }}</div>
                    <div style="opacity:.9; margin-top:6px">Average Processing Time<br><small style="opacity:.85">{{ $stats['avg_processing_hours'] !== null ? 'hrs' : '' }}</small></div>
                </div>
            </div>

            <div class="chart-card">
                <h5>Request Per Month</h5>
                <div style="height:200px;">
                    <canvas id="requestsChart" width="600" height="200"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <h5>Most Requested Document</h5>
                <div style="height:300px;">
                    @if(count($stats['most_requested_documents'] ?? []) > 0)
                        <canvas id="documentsChart" width="600" height="300"></canvas>
                    @else
                        <div style="height:200px; display:flex; align-items:center; justify-content:center; color:#999;">
                            No document request data available yet.
                        </div>
                    @endif
                </div>
            </div>

            <div style="height:16px"></div>
            <h4 class="mb-3">Quick Actions</h4>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <a href="{{ route('admin.users.create') }}" class="text-decoration-none">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Create New User</h5>
                                <p class="card-text text-muted">Add a new staff member or admin user to the system.</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-4 mb-3">
                    <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Manage Users</h5>
                                <p class="card-text text-muted">View and manage all system users.</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-4 mb-3">
                    <a href="#" class="text-decoration-none">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">View Reports</h5>
                                <p class="card-text text-muted">Access system reports and analytics.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Chart is initialized from `resources/js/admin.js` bundle; Chart.js is bundled via npm. --}}

<script>
    // Pass most requested documents data to the admin.js chart
    window.mostRequestedDocuments = @json($stats['most_requested_documents'] ?? []);
</script>
