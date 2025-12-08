@extends('layouts.admin')

@section('title', 'Admin Settings')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Barangay Information & System Settings</h1>
                @if(!request('edit'))
                    <a href="?edit=1" class="btn btn-lg" style="background-color: #ff6b35; color: white; border: none; font-weight: 600; padding: 10px 24px;">
                        Edit Info
                    </a>
                @endif
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Barangay Contact Details Section -->
            <div class="card mb-4">
                <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e2e8f0; padding: 16px 20px;">
                    <h5 style="margin: 0; color: #ff6b35; font-weight: 600;">Barangay Contact Details</h5>
                </div>
                <div class="card-body">
                    @if(request('edit'))
                        <form method="POST" action="{{ route('admin.settings.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <label for="barangay_name" class="form-label">Barangay Name</label>
                                    <input type="text" class="form-control" id="barangay_name" name="barangay_name" value="{{ old('barangay_name', $settings['barangay_name'] ?? 'Barangay San Roque') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="barangay_punong" class="form-label">Punong Barangay</label>
                                    <input type="text" class="form-control" id="barangay_punong" name="barangay_punong" value="{{ old('barangay_punong', $settings['barangay_punong'] ?? 'Hon. Maria C. Santos') }}">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <label for="email_address" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email_address" name="email_address" value="{{ old('email_address', $settings['email_address'] ?? 'contact@sanroque.gov.ph') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone_number" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $settings['phone_number'] ?? '0917-123-4567') }}">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $settings['address'] ?? 'San Roque Hall, Main Street, San Roque') }}">
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-lg" style="background-color: #27ae60; color: white; border: none; font-weight: 600; padding: 12px 24px;">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    @else
                        <dl class="row">
                            <dt class="col-sm-3">Barangay Name</dt>
                            <dd class="col-sm-9">{{ $settings['barangay_name'] ?? 'Barangay San Roque' }}</dd>

                            <dt class="col-sm-3">Punong Barangay</dt>
                            <dd class="col-sm-9">{{ $settings['barangay_punong'] ?? 'Hon. Maria C. Santos' }}</dd>

                            <dt class="col-sm-3">Email Address</dt>
                            <dd class="col-sm-9">{{ $settings['email_address'] ?? 'contact@sanroque.gov.ph' }}</dd>

                            <dt class="col-sm-3">Phone Number</dt>
                            <dd class="col-sm-9">{{ $settings['phone_number'] ?? '0917-123-4567' }}</dd>

                            <dt class="col-sm-3">Address</dt>
                            <dd class="col-sm-9">{{ $settings['address'] ?? 'San Roque Hall, Main Street, San Roque' }}</dd>
                        </dl>
                    @endif
                </div>
            </div>

            <!-- Logout Section -->
            <div class="mb-4">
                <form method="POST" action="{{ route('logout') }}" style="display: grid;">
                    @csrf
                    <button type="submit" class="btn btn-lg btn-danger" style="font-weight: 600; padding: 12px 24px;">
                        Log out
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
