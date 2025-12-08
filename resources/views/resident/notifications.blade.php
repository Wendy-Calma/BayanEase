@extends('layouts.resident')

@section('title', 'Notifications')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">System Notifications</h1>

            @if(isset($notifications) && count($notifications) > 0)
                <div style="max-width: 100%;">
                    @foreach($notifications as $notification)
                        @php
                            // Determine border color based on notification type
                            $borderColors = [
                                'success' => '#27ae60',
                                'error' => '#e74c3c',
                                'warning' => '#ff6b35',
                                'info' => '#3498db',
                            ];
                            $borderColor = $borderColors[$notification->type ?? 'info'] ?? '#95a5a6';
                        @endphp
                        <div class="card mb-3" style="border-left: 5px solid {{ $borderColor }}; border-radius: 6px;">
                            <div class="card-body d-flex justify-content-between align-items-start">
                                <div style="flex-grow: 1;">
                                    <h5 class="card-title" style="color: #2d3748; margin-bottom: 8px;">
                                        {{ $notification->title ?? 'Notification' }}
                                    </h5>
                                    <p class="card-text text-muted" style="color: #4a5568; margin-bottom: 0;">
                                        {{ $notification->message ?? '' }}
                                    </p>
                                </div>
                                <div style="text-align: right; margin-left: 16px; white-space: nowrap;">
                                    <small style="color: #718096; font-size: 12px;">
                                        {{ $notification->created_at ? $notification->created_at->format('m/d/Y') : '' }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card">
                    <div class="card-body text-center py-5">
                        <p class="text-muted" style="color: #718096; font-size: 16px;">
                            You have no notifications at this time.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
