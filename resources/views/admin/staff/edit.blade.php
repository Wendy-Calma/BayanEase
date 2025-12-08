@extends('layouts.admin')

@section('title', 'Edit Staff')

@section('content')
<div class="container-fluid" style="max-width: 600px;">
    <div class="row">
        <div class="col-12">
            <div class="mb-4">
                <h1 style="font-weight: 700; color: #2d3748;">Edit Staff Member</h1>
                <p style="color: #718096;">Update staff account information and status.</p>
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
                    <form method="POST" action="{{ route('admin.staff.update', $staff->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-4">
                            <label for="first_name" style="font-weight: 600; color: #2d3748; margin-bottom: 8px; display: block;">First Name</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name', $staff->first_name) }}" required style="border-radius: 4px; border: 1px solid #e2e8f0; padding: 10px 12px;">
                            @error('first_name')
                                <small style="color: #e74c3c;">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="last_name" style="font-weight: 600; color: #2d3748; margin-bottom: 8px; display: block;">Last Name</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name', $staff->last_name) }}" required style="border-radius: 4px; border: 1px solid #e2e8f0; padding: 10px 12px;">
                            @error('last_name')
                                <small style="color: #e74c3c;">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="email" style="font-weight: 600; color: #2d3748; margin-bottom: 8px; display: block;">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $staff->email) }}" required style="border-radius: 4px; border: 1px solid #e2e8f0; padding: 10px 12px;">
                            @error('email')
                                <small style="color: #e74c3c;">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="phone_number" style="font-weight: 600; color: #2d3748; margin-bottom: 8px; display: block;">Phone Number</label>
                            <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number', $staff->phone_number) }}" required style="border-radius: 4px; border: 1px solid #e2e8f0; padding: 10px 12px;">
                            @error('phone_number')
                                <small style="color: #e74c3c;">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="is_active" style="font-weight: 600; color: #2d3748; margin-bottom: 8px; display: block;">Account Status</label>
                            <select class="form-control" id="is_active" name="is_active" style="border-radius: 4px; border: 1px solid #e2e8f0; padding: 10px 12px;">
                                <option value="1" {{ old('is_active', $staff->is_active) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active', $staff->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div style="display: flex; gap: 10px; margin-top: 30px;">
                            <button type="submit" class="btn" style="background-color: #27ae60; color: white; border: none; font-weight: 600; padding: 10px 30px; border-radius: 4px; flex: 1;">
                                Update Staff Account
                            </button>
                            <a href="{{ route('admin.staff.index') }}" class="btn" style="background-color: #e2e8f0; color: #2d3748; border: none; font-weight: 600; padding: 10px 30px; border-radius: 4px; flex: 1; text-align: center; text-decoration: none;">
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
