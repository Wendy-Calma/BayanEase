@extends('layouts.public')

@section('title', 'Login - Smart Barangay')

@section('content')
<div style="display: flex; min-height: calc(100vh - 150px); align-items: center; justify-content: center; background-color: transparent;">
	<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; max-width: 900px; width: 100%; padding: 40px; background: white; border-radius: 12px; border: 3px solid #FA812F; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
		<!-- Logo Section -->
		<div style="display: flex; align-items: center; justify-content: center;">
			<img src="{{ asset('images/logo.png') }}" alt="Barangay EASE" style="max-width: 100%; height: auto;">
		</div>

		<!-- Login Form Section -->
		<div style="display: flex; flex-direction: column; justify-content: center;">
			<h2 style="text-align: center; color: #2d3748; font-weight: 700; font-size: 32px; margin-bottom: 30px;">Login</h2>

			@if(session('status'))
				<div class="alert alert-info">{{ session('status') }}</div>
			@endif

			@if($errors->any())
				<div class="alert alert-danger">
					<ul class="mb-0">
						@foreach($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			<form method="POST" action="{{ route('login.attempt') }}">
				@csrf

				<div style="margin-bottom: 20px;">
					<label for="email" style="display: block; margin-bottom: 8px; color: #2d3748; font-weight: 500;">Email Address</label>
					<input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus style="padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
					@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
				</div>

				<div style="margin-bottom: 20px;">
					<label for="password" style="display: block; margin-bottom: 8px; color: #2d3748; font-weight: 500;">Password</label>
					<input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" required style="padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
					@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
				</div>

				<div style="text-align: center; margin-bottom: 20px;">
					@if (Route::has('password.request'))
						<a href="{{ route('password.request') }}" style="color: #FA812F; text-decoration: none; font-size: 14px;">Forgot Password?</a>
					@endif
				</div>

				<button type="submit" style="width: 100%; padding: 12px; background-color: #FA812F; color: white; border: none; border-radius: 6px; font-weight: 600; font-size: 16px; cursor: pointer; margin-bottom: 20px;">Login</button>

				<div style="text-align: center;">
					<small style="color: #718096;">Don't have an account? <a href="{{ route('register') }}" style="color: #FA812F; text-decoration: none; font-weight: 600;">Register</a></small>
				</div>
			</form>
		</div>
	</div>
</div>

<style>
	@media (max-width: 768px) {
		div[style*="grid-template-columns: 1fr 1fr"] {
			grid-template-columns: 1fr !important;
		}
	}
</style>
@endsection

