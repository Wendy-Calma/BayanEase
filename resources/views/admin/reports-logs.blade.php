@extends('layouts.admin')

@section('title', 'Reports & Logs')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Reports & System Logs</h1>
        </div>
    </div>

    <div class="row">
        <!-- Full System Reports Section -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e2e8f0; padding: 16px 20px;">
                    <h5 style="margin: 0; color: #2d3748; font-weight: 600;">Full System Reports</h5>
                </div>
                <div class="card-body">
                    <p style="color: #718096; margin-bottom: 20px;">Generate comprehensive data dumps and aggregated reports for quarterly and annual analysis.</p>

                    <div class="mb-4">
                        <label for="report_type" class="form-label" style="font-weight: 600;">Select Report Type</label>
                        <select class="form-select" id="report_type" name="report_type">
                            <option value="">-- Choose Report --</option>
                            <option value="requests_monthly">Monthly Requests Summary</option>
                            <option value="requests_quarterly">Quarterly Requests Summary</option>
                            <option value="requests_annual">Annual Requests Summary</option>
                            <option value="staff_performance">Staff Performance Report</option>
                            <option value="documents_stats">Document Statistics</option>
                        </select>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-lg" style="background-color: #27ae60; color: white; border: none; font-weight: 600; padding: 12px 24px;">
                            Generate & Download CSV
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Logs Section -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e2e8f0; padding: 16px 20px;">
                    <h5 style="margin: 0; color: #2d3748; font-weight: 600;">System Logs</h5>
                </div>
                <div class="card-body">
                    <p style="color: #718096; margin-bottom: 20px;">View automated system events, errors, and warnings from the application log.</p>

                    <div style="background-color: #f8f9fa; padding: 12px; border-radius: 4px; border: 1px solid #e2e8f0; max-height: 300px; overflow-y: auto; font-family: monospace; font-size: 12px; line-height: 1.5;">
                        @if(isset($logs) && count($logs) > 0)
                            @foreach($logs as $log)
                                <div style="color: {{ strpos($log, 'ERROR') !== false ? '#e74c3c' : (strpos($log, 'WARN') !== false ? '#ff6b35' : '#27ae60') }}; margin-bottom: 8px;">
                                    {{ $log }}
                                </div>
                            @endforeach
                        @else
                            <div style="color: #999;">
                                [ERROR] 2024-11-09 18:01 [ERROR] Database connection timeout (rebuild)<br>
                                [INFO] 2024-11-09 17:55 System integrity check completed<br>
                                [WARN] 2024-11-09 10:30 High CPU
                            </div>
                        @endif
                    </div>

                    <div class="d-grid gap-2 mt-3">
                        <a href="#" class="btn btn-lg" style="background-color: #3498db; color: white; border: none; font-weight: 600; padding: 12px 24px;">
                            Download Full Log File
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
