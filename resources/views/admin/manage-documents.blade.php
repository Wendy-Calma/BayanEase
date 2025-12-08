@extends('layouts.admin')

@section('title', 'Manage Documents')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1>Manage Documents</h1>
                    <p style="color: #718096; margin-top: 8px;">Define fees, required processing time, and activation status for resident document requests.</p>
                </div>
                <a href="{{ route('admin.documents.create') }}" class="btn btn-lg" style="background-color: #ff6b35; color: white; border: none; font-weight: 600; padding: 10px 20px;">
                    + Add New Document
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #f8f9fa;">
                            <tr>
                                <th style="font-weight: 600; color: #2d3748;">Document Name</th>
                                <th style="font-weight: 600; color: #2d3748;">Processing Fee (PHP)</th>
                                <th style="font-weight: 600; color: #2d3748;">Required Time</th>
                                <th style="font-weight: 600; color: #2d3748;">Status</th>
                                <th style="font-weight: 600; color: #2d3748;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($documents as $doc)
                                <tr>
                                    <td style="color: #2d3748; font-weight: 500;">{{ $doc->name }}</td>
                                    <td style="color: #2d3748;">{{ isset($doc->processing_fee) ? '₱' . number_format($doc->processing_fee, 2) : 'N/A' }}</td>
                                    <td style="color: #2d3748;">{{ $doc->required_time ?? 'N/A' }}</td>
                                    <td>
                                        @if($doc->is_active ?? true)
                                            <span class="badge" style="background-color: #27ae60; padding: 6px 12px; font-size: 12px; font-weight: 500;">Active</span>
                                        @else
                                            <span class="badge" style="background-color: #e74c3c; padding: 6px 12px; font-size: 12px; font-weight: 500;">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.documents.edit', $doc->id) }}" class="btn btn-sm" style="background-color: #27ae60; color: white; border: none; font-weight: 600; padding: 6px 12px; font-size: 12px;">
                                            Edit
                                        </a>
                                        <button type="button" class="btn btn-sm" style="background-color: #ff6b35; color: white; border: none; font-weight: 600; padding: 6px 12px; font-size: 12px;" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $doc->id }}">
                                            Remove
                                        </button>
                                    </td>
                                </tr>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $doc->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: #ff6b35; border: none;">
                                                <h5 class="modal-title" id="deleteModalLabel" style="color: white; font-weight: 600;">Delete Document</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p style="color: #2d3748; font-size: 16px;">Are you sure you want to delete <strong>{{ $doc->name }}</strong>?</p>
                                                <p style="color: #718096; font-size: 14px;">This action cannot be undone.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <form method="POST" action="{{ route('admin.documents.destroy', $doc->id) }}" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn" style="background-color: #ff6b35; color: white; border: none; font-weight: 600;">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        No documents configured yet. <a href="{{ route('admin.documents.create') }}" style="color: #ff6b35; text-decoration: none;">Add one now</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection