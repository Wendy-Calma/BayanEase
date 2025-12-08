@extends('layouts.admin')

@section('title', 'Add Document Type')

@section('content')
<div class="container-fluid" style="max-width: 600px;">
    <div class="row">
        <div class="col-12">
            <div class="mb-4">
                <h1 style="font-weight: 700; color: #2d3748;">Add New Document Type</h1>
                <p style="color: #718096;">Create a new document type that residents can request.</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger" style="background-color: #fee; border: 1px solid #fcc; color: #c00; border-radius: 4px; padding: 12px;">
                    <strong>Validation errors:</strong>
                    <ul style="margin: 8px 0 0 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card" style="border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-radius: 8px;">
                <div class="card-body" style="padding: 30px;">
                    <form method="POST" action="{{ route('admin.documents.store') }}">
                        @csrf

                        <div class="form-group mb-4">
                            <label for="name" style="font-weight: 600; color: #2d3748; margin-bottom: 8px; display: block;">Document Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="e.g., Barangay Clearance" required style="border-radius: 4px; border: 1px solid #e2e8f0; padding: 10px 12px;">
                            @error('name')
                                <small style="color: #e74c3c;">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="code" style="font-weight: 600; color: #2d3748; margin-bottom: 8px; display: block;">Document Code</label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}" placeholder="e.g., BC" maxlength="20" required style="border-radius: 4px; border: 1px solid #e2e8f0; padding: 10px 12px;">
                            <small style="color: #718096; display: block; margin-top: 4px;">Unique code for this document (max 20 characters)</small>
                            @error('code')
                                <small style="color: #e74c3c;">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="processing_fee" style="font-weight: 600; color: #2d3748; margin-bottom: 8px; display: block;">Processing Fee (₱)</label>
                            <input type="number" class="form-control @error('processing_fee') is-invalid @enderror" id="processing_fee" name="processing_fee" value="{{ old('processing_fee') }}" min="0" step="0.01" placeholder="e.g., 50.00" required style="border-radius: 4px; border: 1px solid #e2e8f0; padding: 10px 12px;">
                            @error('processing_fee')
                                <small style="color: #e74c3c;">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="required_time" style="font-weight: 600; color: #2d3748; margin-bottom: 8px; display: block;">Required Processing Time</label>
                            <input type="text" class="form-control @error('required_time') is-invalid @enderror" id="required_time" name="required_time" value="{{ old('required_time') }}" placeholder="e.g., 2-3 days" required style="border-radius: 4px; border: 1px solid #e2e8f0; padding: 10px 12px;">
                            @error('required_time')
                                <small style="color: #e74c3c;">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="is_active" style="font-weight: 600; color: #2d3748; margin-bottom: 8px; display: block;">Status</label>
                            <select class="form-control" id="is_active" name="is_active" style="border-radius: 4px; border: 1px solid #e2e8f0; padding: 10px 12px;">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div style="display: flex; gap: 10px; margin-top: 30px;">
                            <button type="submit" class="btn" style="background-color: #ff6b35; color: white; border: none; font-weight: 600; padding: 10px 30px; border-radius: 4px; flex: 1;">
                                Add Document Type
                            </button>
                            <a href="{{ route('admin.documents.index') }}" class="btn" style="background-color: #e2e8f0; color: #2d3748; border: none; font-weight: 600; padding: 10px 30px; border-radius: 4px; flex: 1; text-align: center; text-decoration: none;">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
