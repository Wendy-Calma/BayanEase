@extends('layouts.public')

@section('title', 'Create Account - Smart Barangay')

@section('content')
<div style="display: flex; min-height: auto; align-items: flex-start; justify-content: center; background-color: transparent; padding: 40px 20px;">
	<div style="display: grid; grid-template-columns: 350px 1fr; gap: 40px; max-width: 1200px; width: 100%; background: white; border-radius: 12px; border: 3px solid #FA812F; box-shadow: 0 4px 6px rgba(0,0,0,0.1); overflow: hidden;">
		<!-- Logo Section - Fixed -->
		<div style="display: flex; align-items: flex-start; justify-content: center; padding: 40px 20px; position: sticky; top: 0; height: fit-content;">
			<img src="{{ asset('images/logo.png') }}" alt="Barangay EASE" style="max-width: 100%; height: auto;">
		</div>

		<!-- Register Form Section - Scrollable -->
		<div style="padding: 40px; max-height: calc(100vh - 100px); overflow-y: auto;">
			<h2 style="text-align: center; color: #2d3748; font-weight: 700; font-size: 32px; margin-bottom: 10px;">Create Account</h2>
			<p style="text-align: center; color: #718096; margin-bottom: 30px;">Register to start requesting barangay documents online</p>

			<form method="POST" action="{{ route('register.submit') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <!-- Full Name Section -->
                            <div class="col-12">
                                <h5 class="mb-3" style="color: #FA812F; font-weight: 600;">Full Name *</h5>
                            </div>
                            <div class="col-md-4">
                                <label for="surname" class="form-label">Surname *</label>
                                <input id="surname" name="surname" type="text" class="form-control @error('surname') is-invalid @enderror" value="{{ old('surname') }}" required>
                                @error('surname')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label for="first_name" class="form-label">First Name *</label>
                                <input id="first_name" name="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" required>
                                @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label for="middle_name" class="form-label">Middle Name *</label>
                                <input id="middle_name" name="middle_name" type="text" class="form-control @error('middle_name') is-invalid @enderror" value="{{ old('middle_name') }}" required>
                                @error('middle_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Nick Name -->
                            <div class="col-md-6">
                                <label for="nick_name" class="form-label">Nick Name / Alias (Optional)</label>
                                <input id="nick_name" name="nick_name" type="text" class="form-control @error('nick_name') is-invalid @enderror" value="{{ old('nick_name') }}">
                                @error('nick_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Date of Birth -->
                            <div class="col-12">
                                <h5 class="mb-3" style="color: #FA812F; font-weight: 600;">Date of Birth *</h5>
                            </div>
                            <div class="col-md-4">
                                <label for="birth_month" class="form-label">Month *</label>
                                <select id="birth_month" name="birth_month" class="form-select @error('birth_month') is-invalid @enderror" required>
                                    <option value="">Select Month</option>
                                    <option value="01" {{ old('birth_month') == '01' ? 'selected' : '' }}>January</option>
                                    <option value="02" {{ old('birth_month') == '02' ? 'selected' : '' }}>February</option>
                                    <option value="03" {{ old('birth_month') == '03' ? 'selected' : '' }}>March</option>
                                    <option value="04" {{ old('birth_month') == '04' ? 'selected' : '' }}>April</option>
                                    <option value="05" {{ old('birth_month') == '05' ? 'selected' : '' }}>May</option>
                                    <option value="06" {{ old('birth_month') == '06' ? 'selected' : '' }}>June</option>
                                    <option value="07" {{ old('birth_month') == '07' ? 'selected' : '' }}>July</option>
                                    <option value="08" {{ old('birth_month') == '08' ? 'selected' : '' }}>August</option>
                                    <option value="09" {{ old('birth_month') == '09' ? 'selected' : '' }}>September</option>
                                    <option value="10" {{ old('birth_month') == '10' ? 'selected' : '' }}>October</option>
                                    <option value="11" {{ old('birth_month') == '11' ? 'selected' : '' }}>November</option>
                                    <option value="12" {{ old('birth_month') == '12' ? 'selected' : '' }}>December</option>
                                </select>
                                @error('birth_month')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label for="birth_day" class="form-label">Day *</label>
                                <input id="birth_day" name="birth_day" type="number" min="1" max="31" class="form-control @error('birth_day') is-invalid @enderror" value="{{ old('birth_day') }}" required>
                                @error('birth_day')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label for="birth_year" class="form-label">Year *</label>
                                <input id="birth_year" name="birth_year" type="number" min="1900" max="{{ date('Y') }}" class="form-control @error('birth_year') is-invalid @enderror" value="{{ old('birth_year') }}" required>
                                @error('birth_year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Place of Birth -->
                            <div class="col-md-4">
                                <label for="birth_province" class="form-label">Birth Province *</label>
                                <input id="birth_province" name="birth_province" type="text" class="form-control @error('birth_province') is-invalid @enderror" value="{{ old('birth_province') }}" required>
                                @error('birth_province')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label for="birth_city" class="form-label">City / Municipality *</label>
                                <input id="birth_city" name="birth_city" type="text" class="form-control @error('birth_city') is-invalid @enderror" value="{{ old('birth_city') }}" required>
                                @error('birth_city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Citizenship -->
                            <div class="col-md-4">
                                <label for="citizenship" class="form-label">Citizenship *</label>
                                <input id="citizenship" name="citizenship" type="text" class="form-control @error('citizenship') is-invalid @enderror" value="{{ old('citizenship') }}" required>
                                @error('citizenship')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Gender -->
                            <div class="col-md-3">
                                <label for="gender" class="form-label">Gender *</label>
                                <select id="gender" name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Civil Status -->
                            <div class="col-md-3">
                                <label for="civil_status" class="form-label">Civil Status *</label>
                                <select id="civil_status" name="civil_status" class="form-select @error('civil_status') is-invalid @enderror" required>
                                    <option value="">Select Status</option>
                                    <option value="Single" {{ old('civil_status') == 'Single' ? 'selected' : '' }}>Single</option>
                                    <option value="Married" {{ old('civil_status') == 'Married' ? 'selected' : '' }}>Married</option>
                                    <option value="Widowed" {{ old('civil_status') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                    <option value="Separated" {{ old('civil_status') == 'Separated' ? 'selected' : '' }}>Separated</option>
                                </select>
                                @error('civil_status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Religion -->
                            <div class="col-md-3">
                                <label for="religion" class="form-label">Religion *</label>
                                <input id="religion" name="religion" type="text" class="form-control @error('religion') is-invalid @enderror" value="{{ old('religion') }}" required>
                                @error('religion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Education / Occupation -->
                            <div class="col-md-3">
                                <label for="education_occupation" class="form-label">Education / Occupation *</label>
                                <input id="education_occupation" name="education_occupation" type="text" class="form-control @error('education_occupation') is-invalid @enderror" value="{{ old('education_occupation') }}" required placeholder="e.g., Bachelor's Degree / Engineer">
                                @error('education_occupation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Cellphone Number -->
                            <div class="col-md-6">
                                <label for="phone_number" class="form-label">Cellphone Number *</label>
                                <input id="phone_number" name="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number') }}" placeholder="09XXXXXXXXX" required>
                                @error('phone_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Email Address -->
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address *</label>
                                <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Spouse and Parents -->
                            <div class="col-12">
                                <h5 class="mb-3" style="color: #FA812F; font-weight: 600;">Family Information *</h5>
                            </div>
                            <div class="col-md-6">
                                <label for="spouse_name" class="form-label">Spouse Name (if married)</label>
                                <input id="spouse_name" name="spouse_name" type="text" class="form-control @error('spouse_name') is-invalid @enderror" value="{{ old('spouse_name') }}">
                                @error('spouse_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="father_name" class="form-label">Father's Name *</label>
                                <input id="father_name" name="father_name" type="text" class="form-control @error('father_name') is-invalid @enderror" value="{{ old('father_name') }}" required>
                                @error('father_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="mother_name" class="form-label">Mother's Name *</label>
                                <input id="mother_name" name="mother_name" type="text" class="form-control @error('mother_name') is-invalid @enderror" value="{{ old('mother_name') }}" required>
                                @error('mother_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Address -->
                            <div class="col-12">
                                <label for="complete_address" class="form-label">Complete Address *</label>
                                <input id="complete_address" name="complete_address" type="text" class="form-control @error('complete_address') is-invalid @enderror" value="{{ old('complete_address') }}" placeholder="Street, Barangay, City, Province, Zip Code" required>
                                @error('complete_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Nature of Residency -->
                            <div class="col-md-6">
                                <label for="residency_type" class="form-label">Nature of Residency *</label>
                                <select id="residency_type" name="residency_type" class="form-select @error('residency_type') is-invalid @enderror" required>
                                    <option value="">Select Type</option>
                                    <option value="Owner" {{ old('residency_type') == 'Owner' ? 'selected' : '' }}>Owner</option>
                                    <option value="Renter" {{ old('residency_type') == 'Renter' ? 'selected' : '' }}>Renter</option>
                                    <option value="Living with Family" {{ old('residency_type') == 'Living with Family' ? 'selected' : '' }}>Living with Family</option>
                                </select>
                                @error('residency_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Period of Residency -->
                            <div class="col-md-6">
                                <label for="residency_years" class="form-label">Years of Residency *</label>
                                <input id="residency_years" name="residency_years" type="number" min="0" class="form-control @error('residency_years') is-invalid @enderror" value="{{ old('residency_years') }}" placeholder="e.g., 5" required>
                                @error('residency_years')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- ID Picture -->
                            <div class="col-12">
                                <h5 class="mb-3" style="color: #FA812F; font-weight: 600;">Documents *</h5>
                            </div>
                            <div class="col-md-6">
                                <label for="id_picture" class="form-label">1x1 ID Picture (JPG, PNG) *</label>
                                <input id="id_picture" name="id_picture" type="file" accept="image/jpeg,image/png" class="form-control @error('id_picture') is-invalid @enderror" required>
                                <small class="form-text text-muted">Max file size: 5MB. Supported: JPG, PNG</small>
                                @error('id_picture')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Digital Signature -->
                            <div class="col-md-6">
                                <label for="digital_signature" class="form-label">Digital Signature / Signature Image (JPG, PNG) *</label>
                                <input id="digital_signature" name="digital_signature" type="file" accept="image/jpeg,image/png" class="form-control @error('digital_signature') is-invalid @enderror" required>
                                <small class="form-text text-muted">Max file size: 5MB. Supported: JPG, PNG</small>
                                @error('digital_signature')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Password -->
                            <div class="col-12">
                                <h5 class="mb-3" style="color: #FA812F; font-weight: 600;">Account Credentials *</h5>
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password *</label>
                                <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" required>
                                <div class="form-text">At least 8 characters</div>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirm Password *</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" required>
                            </div>

                            <!-- Terms & Conditions -->
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" id="terms" name="terms" {{ old('terms') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="terms">I agree to the <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a> *</label>
                                    @error('terms')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-12 text-center mt-3">
                                <button type="submit" class="btn btn-warning btn-lg" style="background-color:#FA812F; border-color:#FA812F;">Create Account</button>
                            </div>

                            <div class="col-12 text-center mt-3">
                                <small class="text-muted">Already have an account? <a href="{{ route('login') }}">Log in</a></small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const form = e.target;
            const formData = new FormData(form);
            
            // Clear all previous errors
            document.querySelectorAll('.form-control.is-invalid, .form-select.is-invalid').forEach(el => {
                el.classList.remove('is-invalid');
            });
            document.querySelectorAll('.invalid-feedback').forEach(el => {
                el.style.display = 'none';
            });
            
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    alert(data.message);
                    window.location.href = data.redirect;
                } else {
                    // Display validation errors if present
                    if (data.errors) {
                        console.log('Validation errors:', data.errors);
                        
                        Object.keys(data.errors).forEach(field => {
                            // Find input by name
                            const input = form.querySelector(`[name="${field}"]`);
                            if (input) {
                                input.classList.add('is-invalid');
                                
                                // Find or create error feedback element
                                let errorEl = input.parentElement.querySelector('.invalid-feedback');
                                if (!errorEl) {
                                    errorEl = document.createElement('div');
                                    errorEl.className = 'invalid-feedback';
                                    input.parentElement.appendChild(errorEl);
                                }
                                
                                // Display the first error message
                                errorEl.textContent = data.errors[field][0];
                                errorEl.style.display = 'block';
                            }
                        });
                        
                        alert('Please fix the validation errors above.');
                    } else {
                        alert(data.message || 'Registration failed. Please try again.');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            }
        });
    </script>

<style>
	@media (max-width: 768px) {
		div[style*="grid-template-columns: 350px"] {
			grid-template-columns: 1fr !important;
		}
	}
</style>
@endsection
