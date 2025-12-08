@extends('layouts.admin')

@section('title', 'Audit Trail')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-2">Audit Trail (User Activity)</h1>
            <p style="color: #718096; margin-bottom: 20px;">Track every action taken by Administrators and Barangay Officers for accountability.</p>

            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #f8f9fa;">
                            <tr>
                                <th style="font-weight: 600; color: #2d3748;">Timestamp</th>
                                <th style="font-weight: 600; color: #2d3748;">User</th>
                                <th style="font-weight: 600; color: #2d3748;">Action Performed</th>
                                <th style="font-weight: 600; color: #2d3748;">Category</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($auditLogs as $log)
                                <tr>
                                    <td style="color: #2d3748; font-weight: 500; font-size: 12px;">
                                        {{ $log->created_at ? $log->created_at->format('Y-m-d H:i') : '' }}
                                    </td>
                                    <td style="color: #2d3748;">
                                        {{ $log->user->first_name ?? 'System' }} {{ $log->user->last_name ?? '' }}
                                    </td>
                                    <td style="color: #2d3748;">{{ $log->description ?? $log->action }}</td>
                                    <td>
                                        @php
                                            $categoryColor = match($log->category ?? 'general') {
                                                'request' => '#3498db',
                                                'staff' => '#9b59b6',
                                                'settings' => '#f39c12',
                                                'system' => '#95a5a6',
                                                default => '#34495e',
                                            };
                                        @endphp
                                        <span class="badge" style="background-color: {{ $categoryColor }}; padding: 6px 12px; font-size: 12px; font-weight: 500;">
                                            {{ ucfirst($log->category ?? 'General') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        No audit logs found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if(isset($auditLogs) && $auditLogs->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $auditLogs->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
