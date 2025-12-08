@extends('layouts.resident')

@section('title', 'My Profile & Settings')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>My Profile & Settings</h1>
                @if(!request('edit'))
                    <a href="?edit=1" class="btn btn-lg" style="background-color: #ff6b35; color: white; border: none; font-weight: 600; padding: 10px 24px;">
                        Edit Profile
                    </a>
                @endif
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Personal & Contact Details Section -->
            <div class="card mb-4">
                <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e2e8f0; padding: 16px 20px;">
                    <h5 style="margin: 0; color: #ff6b35; font-weight: 600;">Personal & Contact Details</h5>
                </div>
                <div class="card-body">
                    @if(request('edit'))
                        <form method="POST" action="{{ route('settings.profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Full Name Section -->
                            <h6 class="mb-3" style="color: #ff6b35; font-weight: 600;">Full Name</h6>
                            <div class="row mb-4">
                                <div class="col-md-4 mb-3">
                                    <label for="surname" class="form-label">Surname</label>
                                    <input type="text" class="form-control @error('surname') is-invalid @enderror" id="surname" name="surname" value="{{ old('surname', auth()->user()->surname) }}" required>
                                    @error('surname') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name', auth()->user()->first_name) }}" required>
                                    @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="middle_name" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control @error('middle_name') is-invalid @enderror" id="middle_name" name="middle_name" value="{{ old('middle_name', auth()->user()->middle_name) }}" required>
                                    @error('middle_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Nick Name -->
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <label for="nick_name" class="form-label">Nick Name / Alias (Optional)</label>
                                    <input type="text" class="form-control @error('nick_name') is-invalid @enderror" id="nick_name" name="nick_name" value="{{ old('nick_name', auth()->user()->nick_name) }}">
                                    @error('nick_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Date of Birth -->
                            <h6 class="mb-3" style="color: #ff6b35; font-weight: 600;">Date of Birth</h6>
                            <div class="row mb-4">
                                <div class="col-md-4 mb-3">
                                    <label for="birth_month" class="form-label">Month</label>
                                    <select id="birth_month" name="birth_month" class="form-select @error('birth_month') is-invalid @enderror" required>
                                        <option value="">Select Month</option>
                                        <option value="01" {{ old('birth_month', auth()->user()->birth_month) == '01' ? 'selected' : '' }}>January</option>
                                        <option value="02" {{ old('birth_month', auth()->user()->birth_month) == '02' ? 'selected' : '' }}>February</option>
                                        <option value="03" {{ old('birth_month', auth()->user()->birth_month) == '03' ? 'selected' : '' }}>March</option>
                                        <option value="04" {{ old('birth_month', auth()->user()->birth_month) == '04' ? 'selected' : '' }}>April</option>
                                        <option value="05" {{ old('birth_month', auth()->user()->birth_month) == '05' ? 'selected' : '' }}>May</option>
                                        <option value="06" {{ old('birth_month', auth()->user()->birth_month) == '06' ? 'selected' : '' }}>June</option>
                                        <option value="07" {{ old('birth_month', auth()->user()->birth_month) == '07' ? 'selected' : '' }}>July</option>
                                        <option value="08" {{ old('birth_month', auth()->user()->birth_month) == '08' ? 'selected' : '' }}>August</option>
                                        <option value="09" {{ old('birth_month', auth()->user()->birth_month) == '09' ? 'selected' : '' }}>September</option>
                                        <option value="10" {{ old('birth_month', auth()->user()->birth_month) == '10' ? 'selected' : '' }}>October</option>
                                        <option value="11" {{ old('birth_month', auth()->user()->birth_month) == '11' ? 'selected' : '' }}>November</option>
                                        <option value="12" {{ old('birth_month', auth()->user()->birth_month) == '12' ? 'selected' : '' }}>December</option>
                                    </select>
                                    @error('birth_month') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="birth_day" class="form-label">Day</label>
                                    <input type="number" min="1" max="31" class="form-control @error('birth_day') is-invalid @enderror" id="birth_day" name="birth_day" value="{{ old('birth_day', auth()->user()->birth_day) }}" required>
                                    @error('birth_day') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="birth_year" class="form-label">Year</label>
                                    <input type="number" min="1900" max="{{ date('Y') }}" class="form-control @error('birth_year') is-invalid @enderror" id="birth_year" name="birth_year" value="{{ old('birth_year', auth()->user()->birth_year) }}" required>
                                    @error('birth_year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Place of Birth -->
                            <h6 class="mb-3" style="color: #ff6b35; font-weight: 600;">Place of Birth</h6>
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <label for="birth_province" class="form-label">Province</label>
                                    <input type="text" class="form-control @error('birth_province') is-invalid @enderror" id="birth_province" name="birth_province" value="{{ old('birth_province', auth()->user()->birth_province) }}" required>
                                    @error('birth_province') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="birth_city" class="form-label">City / Municipality</label>
                                    <input type="text" class="form-control @error('birth_city') is-invalid @enderror" id="birth_city" name="birth_city" value="{{ old('birth_city', auth()->user()->birth_city) }}" required>
                                    @error('birth_city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Personal Information -->
                            <h6 class="mb-3" style="color: #ff6b35; font-weight: 600;">Personal Information</h6>
                            <div class="row mb-4">
                                <div class="col-md-3 mb-3">
                                    <label for="citizenship" class="form-label">Citizenship</label>
                                    <input type="text" class="form-control @error('citizenship') is-invalid @enderror" id="citizenship" name="citizenship" value="{{ old('citizenship', auth()->user()->citizenship) }}" required>
                                    @error('citizenship') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select id="gender" name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male" {{ old('gender', auth()->user()->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('gender', auth()->user()->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                        <option value="Other" {{ old('gender', auth()->user()->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('gender') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="civil_status" class="form-label">Civil Status</label>
                                    <select id="civil_status" name="civil_status" class="form-select @error('civil_status') is-invalid @enderror" required>
                                        <option value="">Select Status</option>
                                        <option value="Single" {{ old('civil_status', auth()->user()->civil_status) == 'Single' ? 'selected' : '' }}>Single</option>
                                        <option value="Married" {{ old('civil_status', auth()->user()->civil_status) == 'Married' ? 'selected' : '' }}>Married</option>
                                        <option value="Widowed" {{ old('civil_status', auth()->user()->civil_status) == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                        <option value="Separated" {{ old('civil_status', auth()->user()->civil_status) == 'Separated' ? 'selected' : '' }}>Separated</option>
                                    </select>
                                    @error('civil_status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="religion" class="form-label">Religion</label>
                                    <input type="text" class="form-control @error('religion') is-invalid @enderror" id="religion" name="religion" value="{{ old('religion', auth()->user()->religion) }}" required>
                                    @error('religion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Education / Occupation -->
                            <div class="row mb-4">
                                <div class="col-md-12 mb-3">
                                    <label for="education_occupation" class="form-label">Highest Educational Attainment / Occupation</label>
                                    <input type="text" class="form-control @error('education_occupation') is-invalid @enderror" id="education_occupation" name="education_occupation" value="{{ old('education_occupation', auth()->user()->education_occupation) }}" required>
                                    @error('education_occupation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <h6 class="mb-3" style="color: #ff6b35; font-weight: 600;">Contact Information</h6>
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <label for="phone_number" class="form-label">Cellphone Number</label>
                                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number', auth()->user()->phone_number) }}" required>
                                    @error('phone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Family Information -->
                            <h6 class="mb-3" style="color: #ff6b35; font-weight: 600;">Family Information</h6>
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <label for="spouse_name" class="form-label">Spouse Name (if married)</label>
                                    <input type="text" class="form-control @error('spouse_name') is-invalid @enderror" id="spouse_name" name="spouse_name" value="{{ old('spouse_name', auth()->user()->spouse_name) }}">
                                    @error('spouse_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="father_name" class="form-label">Father's Name</label>
                                    <input type="text" class="form-control @error('father_name') is-invalid @enderror" id="father_name" name="father_name" value="{{ old('father_name', auth()->user()->father_name) }}" required>
                                    @error('father_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <label for="mother_name" class="form-label">Mother's Name</label>
                                    <input type="text" class="form-control @error('mother_name') is-invalid @enderror" id="mother_name" name="mother_name" value="{{ old('mother_name', auth()->user()->mother_name) }}" required>
                                    @error('mother_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Address & Residency -->
                            <h6 class="mb-3" style="color: #ff6b35; font-weight: 600;">Address & Residency</h6>
                            <div class="mb-4">
                                <label for="complete_address" class="form-label">Complete Address</label>
                                <input type="text" class="form-control @error('complete_address') is-invalid @enderror" id="complete_address" name="complete_address" value="{{ old('complete_address', auth()->user()->complete_address) }}" required>
                                @error('complete_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <label for="residency_type" class="form-label">Nature of Residency</label>
                                    <select id="residency_type" name="residency_type" class="form-select @error('residency_type') is-invalid @enderror" required>
                                        <option value="">Select Type</option>
                                        <option value="Owner" {{ old('residency_type', auth()->user()->residency_type) == 'Owner' ? 'selected' : '' }}>Owner</option>
                                        <option value="Renter" {{ old('residency_type', auth()->user()->residency_type) == 'Renter' ? 'selected' : '' }}>Renter</option>
                                        <option value="Living with Family" {{ old('residency_type', auth()->user()->residency_type) == 'Living with Family' ? 'selected' : '' }}>Living with Family</option>
                                    </select>
                                    @error('residency_type') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="residency_years" class="form-label">Years of Residency</label>
                                    <input type="number" min="0" class="form-control @error('residency_years') is-invalid @enderror" id="residency_years" name="residency_years" value="{{ old('residency_years', auth()->user()->residency_years) }}" required>
                                    @error('residency_years') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Documents -->
                            <h6 class="mb-3" style="color: #ff6b35; font-weight: 600;">Documents</h6>
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <label for="id_picture" class="form-label">1x1 ID Picture (JPG, PNG)</label>
                                    @if(auth()->user()->id_picture)
                                        <div class="mb-2">
                                            <small class="text-muted">Current: <a href="{{ asset('storage/' . auth()->user()->id_picture) }}" target="_blank">View Image</a></small>
                                        </div>
                                    @endif
                                    <input type="file" accept="image/jpeg,image/png" class="form-control @error('id_picture') is-invalid @enderror" id="id_picture" name="id_picture">
                                    <small class="form-text text-muted">Max file size: 5MB. Supported: JPG, PNG</small>
                                    @error('id_picture') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="digital_signature" class="form-label">Digital Signature / Signature Image (JPG, PNG)</label>
                                    @if(auth()->user()->digital_signature)
                                        <div class="mb-2">
                                            <small class="text-muted">Current: <a href="{{ asset('storage/' . auth()->user()->digital_signature) }}" target="_blank">View Image</a></small>
                                        </div>
                                    @endif
                                    <input type="file" accept="image/jpeg,image/png" class="form-control @error('digital_signature') is-invalid @enderror" id="digital_signature" name="digital_signature">
                                    <small class="form-text text-muted">Max file size: 5MB. Supported: JPG, PNG</small>
                                    @error('digital_signature') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="d-grid gap-2 mb-4">
                                <button type="submit" class="btn btn-lg" style="background-color: #27ae60; color: white; border: none; font-weight: 600; padding: 12px 24px;">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    @else
                        <!-- Display Mode -->
                        <dl class="row">
                            <dt class="col-sm-3">Full Name</dt>
                            <dd class="col-sm-9">{{ auth()->user()->surname }} {{ auth()->user()->first_name }} {{ auth()->user()->middle_name }}</dd>

                            @if(auth()->user()->nick_name)
                                <dt class="col-sm-3">Nick Name</dt>
                                <dd class="col-sm-9">{{ auth()->user()->nick_name }}</dd>
                            @endif

                            <dt class="col-sm-3">Date of Birth</dt>
                            <dd class="col-sm-9">{{ auth()->user()->birth_month }}/{{ auth()->user()->birth_day }}/{{ auth()->user()->birth_year }}</dd>

                            <dt class="col-sm-3">Place of Birth</dt>
                            <dd class="col-sm-9">{{ auth()->user()->birth_city }}, {{ auth()->user()->birth_province }}</dd>

                            <dt class="col-sm-3">Citizenship</dt>
                            <dd class="col-sm-9">{{ auth()->user()->citizenship }}</dd>

                            <dt class="col-sm-3">Gender</dt>
                            <dd class="col-sm-9">{{ auth()->user()->gender }}</dd>

                            <dt class="col-sm-3">Civil Status</dt>
                            <dd class="col-sm-9">{{ auth()->user()->civil_status }}</dd>

                            <dt class="col-sm-3">Religion</dt>
                            <dd class="col-sm-9">{{ auth()->user()->religion }}</dd>

                            <dt class="col-sm-3">Education / Occupation</dt>
                            <dd class="col-sm-9">{{ auth()->user()->education_occupation }}</dd>

                            <dt class="col-sm-3">Phone Number</dt>
                            <dd class="col-sm-9">{{ auth()->user()->phone_number }}</dd>

                            <dt class="col-sm-3">Email Address</dt>
                            <dd class="col-sm-9">{{ auth()->user()->email }}</dd>

                            @if(auth()->user()->spouse_name)
                                <dt class="col-sm-3">Spouse Name</dt>
                                <dd class="col-sm-9">{{ auth()->user()->spouse_name }}</dd>
                            @endif

                            <dt class="col-sm-3">Father's Name</dt>
                            <dd class="col-sm-9">{{ auth()->user()->father_name }}</dd>

                            <dt class="col-sm-3">Mother's Name</dt>
                            <dd class="col-sm-9">{{ auth()->user()->mother_name }}</dd>

                            <dt class="col-sm-3">Address</dt>
                            <dd class="col-sm-9">{{ auth()->user()->complete_address }}</dd>

                            <dt class="col-sm-3">Nature of Residency</dt>
                            <dd class="col-sm-9">{{ auth()->user()->residency_type }}</dd>

                            <dt class="col-sm-3">Years of Residency</dt>
                            <dd class="col-sm-9">{{ auth()->user()->residency_years }}</dd>

                            @if(auth()->user()->id_picture)
                                <dt class="col-sm-3">ID Picture</dt>
                                <dd class="col-sm-9"><a href="{{ asset('storage/' . auth()->user()->id_picture) }}" target="_blank">View</a></dd>
                            @endif

                            @if(auth()->user()->digital_signature)
                                <dt class="col-sm-3">Digital Signature</dt>
                                <dd class="col-sm-9"><a href="{{ asset('storage/' . auth()->user()->digital_signature) }}" target="_blank">View</a></dd>
                            @endif
                        </dl>
                    @endif
                </div>
            </div>

            <!-- Account Credentials Section -->
            @if(request('edit'))
                <div class="card mb-4">
                    <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e2e8f0; padding: 16px 20px;">
                        <h5 style="margin: 0; color: #ff6b35; font-weight: 600;">Account Credentials</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('settings.password.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
                                @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Change Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-lg" style="background-color: #27ae60; color: white; border: none; font-weight: 600; padding: 12px 24px;">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Registered Dependents Section -->
            <div class="card mb-4">
                <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e2e8f0; padding: 16px 20px;">
                    <h5 style="margin: 0; color: #ff6b35; font-weight: 600;">Registered Dependents ({{ count($dependents ?? []) }})</h5>
                </div>
                <div class="card-body">
                    @if(isset($dependents) && count($dependents) > 0)
                        @foreach($dependents as $dependent)
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3" style="border-bottom: 1px solid #e2e8f0;">
                                <div>
                                    <strong style="color: #2d3748;">{{ $dependent->first_name }} {{ $dependent->last_name }}</strong>
                                    <br>
                                    <small style="color: #718096;">{{ $dependent->relationship ?? 'Dependent' }}</small>
                                </div>
                                <div style="text-align: right;">
                                    <small style="color: #718096;">({{ $dependent->age ?? 'Age unknown' }})</small>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">No registered dependents.</p>
                    @endif

                    <div class="d-grid gap-2 mt-4">
                        <button type="button" class="btn btn-lg" style="background-color: #ff6b35; color: white; border: none; font-weight: 600; padding: 12px 24px;" data-bs-toggle="modal" data-bs-target="#addDependentModal">
                            + Add New Dependents
                        </button>
                    </div>
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

<!-- Add Dependent Modal -->
<div class="modal fade" id="addDependentModal" tabindex="-1" aria-labelledby="addDependentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #f8f9fa; border-bottom: 2px solid #e2e8f0;">
                <h5 class="modal-title" id="addDependentModalLabel" style="color: #2d3748; font-weight: 600;">
                    <i class="fas fa-user-plus"></i> Add New Dependent
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addDependentForm" method="POST" action="{{ route('dependent.store') }}">
                @csrf
                <div class="modal-body">
                    <!-- First Name -->
                    <div class="mb-3">
                        <label for="dependent_first_name" class="form-label">
                            First Name
                            <span style="color: #ff6b35;">*</span>
                        </label>
                        <input type="text" class="form-control" id="dependent_first_name" name="first_name" required>
                    </div>

                    <!-- Last Name -->
                    <div class="mb-3">
                        <label for="dependent_last_name" class="form-label">
                            Last Name
                            <span style="color: #ff6b35;">*</span>
                        </label>
                        <input type="text" class="form-control" id="dependent_last_name" name="last_name" required>
                    </div>

                    <!-- Relationship -->
                    <div class="mb-3">
                        <label for="dependent_relationship" class="form-label">
                            Relationship
                            <span style="color: #ff6b35;">*</span>
                        </label>
                        <select class="form-select" id="dependent_relationship" name="relationship" required>
                            <option value="">Select relationship</option>
                            <option value="child">Child</option>
                            <option value="spouse">Spouse</option>
                            <option value="parent">Parent</option>
                            <option value="sibling">Sibling</option>
                            <option value="grandchild">Grandchild</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <!-- Date of Birth -->
                    <div class="mb-3">
                        <label for="dependent_dob" class="form-label">
                            Date of Birth
                            <span style="color: #ff6b35;">*</span>
                        </label>
                        <input type="date" class="form-control" id="dependent_dob" name="date_of_birth" required>
                    </div>

                    <!-- Gender -->
                    <div class="mb-3">
                        <label for="dependent_gender" class="form-label">
                            Gender
                            <span style="color: #ff6b35;">*</span>
                        </label>
                        <select class="form-select" id="dependent_gender" name="gender" required>
                            <option value="">Select gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <!-- Civil Status -->
                    <div class="mb-3">
                        <label for="dependent_civil_status" class="form-label">
                            Civil Status
                            <span style="color: #ff6b35;">*</span>
                        </label>
                        <select class="form-select" id="dependent_civil_status" name="civil_status" required>
                            <option value="">Select civil status</option>
                            <option value="single">Single</option>
                            <option value="married">Married</option>
                            <option value="widowed">Widowed</option>
                            <option value="separated">Separated</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 2px solid #e2e8f0;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn" style="background-color: #ff6b35; color: white; font-weight: 600;">
                        <i class="fas fa-save"></i> Save Dependent
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
