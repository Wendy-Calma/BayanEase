@extends('layouts.resident')

@section('title', 'My Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-2">My Dashboard</h1>

            <div class="stats-row">
                <div class="stat-card stat-orange">
                    <div style="font-size:28px; font-weight:700">{{ \App\Models\DocumentRequest::where('user_id', auth()->id())->count() }}</div>
                    <div style="opacity:.9; margin-top:6px">Total Requests<br><small style="opacity:.85">(All time)</small></div>
                </div>

                <div class="stat-card stat-blue">
                    <div style="font-size:28px; font-weight:700">{{ $activeRequests ?? 0 }}</div>
                    <div style="opacity:.9; margin-top:6px">Active Requests</div>
                </div>

                <div class="stat-card stat-green">
                    <div style="font-size:28px; font-weight:700">{{ $readyForPickup ?? 0 }}</div>
                    <div style="opacity:.9; margin-top:6px">Ready for Pickup</div>
                </div>
            </div>

            <div class="chart-card">
                <h5>My Requests Per Month</h5>
                <div style="height:200px;">
                    <canvas id="requestsChart" width="600" height="200"></canvas>
                </div>
            </div>

            <div style="height:16px"></div>
            <h4 class="mb-3">Quick Actions</h4>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <a href="{{ route('document.request') }}" class="text-decoration-none">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Request a Document</h5>
                                <p class="card-text text-muted">Start a new document request.</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-4 mb-3">
                    <a href="{{ route('request.track') }}" class="text-decoration-none">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Track Requests</h5>
                                <p class="card-text text-muted">Check status of your requests.</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-4 mb-3">
                    <a href="{{ route('notifications') }}" class="text-decoration-none">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Notifications</h5>
                                <p class="card-text text-muted">View your latest notifications.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div style="height:16px"></div>
            <h4 class="mb-3">Latest Request Status</h4>
            <div class="card">
                <div class="card-body">
                    @if(isset($latestRequest))
                        <dl class="row">
                            <dt class="col-sm-3">Reference No:</dt>
                            <dd class="col-sm-9">{{ $latestRequest->reference_number }}</dd>

                            <dt class="col-sm-3">Document Type:</dt>
                            <dd class="col-sm-9">{{ $latestRequest->document_type->name ?? ($latestRequest->document_type ?? '') }}</dd>

                            <dt class="col-sm-3">Status:</dt>
                            <dd class="col-sm-9"><span class="badge bg-primary">{{ $latestRequest->status }}</span></dd>

                            <dt class="col-sm-3">Date Submitted:</dt>
                            <dd class="col-sm-9">{{ $latestRequest->created_at ? $latestRequest->created_at->format('F d, Y') : '' }}</dd>
                        </dl>
                    @else
                        <p class="text-muted">You have no requests yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection