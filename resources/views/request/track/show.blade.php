@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Sidebar (same as other pages) -->
    <div class="fixed left-0 top-0 h-full w-64 bg-white shadow-lg">
        <!-- Logo -->
        <div class="px-6 py-4 border-b">
            <span class="text-2xl font-bold text-orange-500">eSyan</span>
        </div>

        <!-- Navigation Menu -->
        <nav class="mt-6">
            <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
                <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('document.request') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
                <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Request Document
            </a>

            <a href="{{ route('request.track') }}" class="flex items-center px-6 py-3 bg-orange-500 text-white">
                <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
                Track Request
            </a>

            <a href="{{ route('notifications') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
                <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                Notifications
            </a>

            <a href="{{ route('settings') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
                <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Settings
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="ml-64 p-8">
        <div class="max-w-4xl mx-auto">
            <div class="mb-6">
                <a href="{{ route('request.track') }}" class="text-orange-600 hover:text-orange-700 flex items-center">
                    <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Request List
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <!-- Request Header -->
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">Request Details</h1>
                            <p class="mt-1 text-sm text-gray-500">Reference No: {{ $request->reference_number }}</p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($request->status === 'completed') bg-green-100 text-green-800
                            @elseif($request->status === 'processing') bg-blue-100 text-blue-800
                            @elseif($request->status === 'ready') bg-purple-100 text-purple-800
                            @else bg-yellow-100 text-yellow-800
                            @endif">
                            {{ ucfirst($request->status) }}
                        </span>
                    </div>
                </div>

                <!-- Request Information -->
                <div class="px-6 py-4">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Document Type</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $request->documentType->name }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Submitted On</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $request->created_at->format('F d, Y h:i A') }}</p>
                        </div>
                        <div class="col-span-2">
                            <h3 class="text-sm font-medium text-gray-500">Purpose</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $request->purpose }}</p>
                        </div>
                    </div>

                    <!-- Uploaded Documents -->
                    @if($request->uploadedDocuments->count() > 0)
                        <div class="mt-6">
                            <h3 class="text-sm font-medium text-gray-500 mb-3">Uploaded Documents</h3>
                            <ul class="divide-y divide-gray-200">
                                @foreach($request->uploadedDocuments as $document)
                                    <li class="py-3 flex justify-between items-center">
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="text-sm text-gray-900">{{ $document->original_name }}</span>
                                        </div>
                                        <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="text-orange-600 hover:text-orange-700 text-sm">
                                            View
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Status Timeline -->
                    <div class="mt-8">
                        <h3 class="text-sm font-medium text-gray-500 mb-4">Request Timeline</h3>
                        <div class="flow-root">
                            <ul role="list" class="-mb-8">
                                @foreach($request->statusHistory as $history)
                                    <li>
                                        <div class="relative pb-8">
                                            @if(!$loop->last)
                                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                            @endif
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white
                                                        @if($history->status === 'completed') bg-green-500
                                                        @elseif($history->status === 'processing') bg-blue-500
                                                        @elseif($history->status === 'ready') bg-purple-500
                                                        @else bg-yellow-500
                                                        @endif">
                                                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <div class="text-sm">
                                                        <p class="font-medium text-gray-900">
                                                            Status changed to {{ ucfirst($history->status) }}
                                                        </p>
                                                        <p class="mt-0.5 text-gray-500">
                                                            {{ $history->created_at->format('F d, Y h:i A') }}
                                                        </p>
                                                    </div>
                                                    @if($history->notes)
                                                        <div class="mt-2">
                                                            <p class="text-sm text-gray-700">{{ $history->notes }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection