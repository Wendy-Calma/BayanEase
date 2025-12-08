@extends('layouts.admin')

@section('title', 'Manage Staff')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Manage Staff Accounts</h1>
                <a href="{{ route('admin.staff.create') }}" class="btn btn-lg" style="background-color: #ff6b35; color: white; border: none; font-weight: 600; padding: 10px 20px;">
                    + Add New Staff
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <p style="color: #718096; margin-bottom: 20px;">{{ count($staff ?? []) }} staff accounts managed.</p>

            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #f8f9fa;">
                            <tr>
                                <th style="font-weight: 600; color: #2d3748;">Name</th>
                                <th style="font-weight: 600; color: #2d3748;">Email</th>
                                <th style="font-weight: 600; color: #2d3748;">Phone</th>
                                <th style="font-weight: 600; color: #2d3748;">Role</th>
                                <th style="font-weight: 600; color: #2d3748;">Status</th>
                                <th style="font-weight: 600; color: #2d3748;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($staff as $member)
                                <tr>
                                    <td style="color: #2d3748; font-weight: 500;">
                                        {{ $member->first_name }} {{ $member->last_name }}
                                    </td>
                                    <td style="color: #2d3748;">{{ $member->email }}</td>
                                    <td style="color: #2d3748;">{{ $member->phone_number ?? 'N/A' }}</td>
                                    <td style="color: #2d3748;">
                                        {{ $member->role->name ? ucfirst(str_replace('_', ' ', $member->role->name)) : 'N/A' }}
                                    </td>
                                    <td>
                                        @if($member->is_active)
                                            <span class="badge" style="background-color: #27ae60; padding: 6px 12px; font-size: 12px; font-weight: 500;">Active</span>
                                        @else
                                            <span class="badge" style="background-color: #e74c3c; padding: 6px 12px; font-size: 12px; font-weight: 500;">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.staff.edit', $member->id) }}" class="btn btn-sm" style="background-color: #27ae60; color: white; border: none; font-weight: 600; padding: 6px 12px; font-size: 12px;">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.staff.destroy', $member->id) }}" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" style="font-weight: 600; padding: 6px 12px; font-size: 12px;" onclick="return confirm('Are you sure?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        No staff members found. <a href="{{ route('admin.staff.create') }}" style="color: #ff6b35; text-decoration: none;">Add one now</a>
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
