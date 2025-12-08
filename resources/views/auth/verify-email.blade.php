@extends('layouts.public')

@section('content')
<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div style="background: white; border-radius: 8px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); max-width: 450px; width: 100%; margin: 20px;">
        <div style="background: #FA812F; color: white; padding: 30px; text-align: center; border-radius: 8px 8px 0 0;">
            <h1 style="margin: 0; font-size: 28px; font-weight: bold;">Verify Your Email</h1>
        </div>

        <div style="padding: 40px;">
            @if ($errors->any())
                <div style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
                    <strong>Error:</strong>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
                    {{ session('success') }}
                </div>
            @endif

            <h2 style="font-size: 20px; margin-bottom: 20px; color: #333;">Verify Your Email Address</h2>
            
            <p style="color: #666; line-height: 1.6; margin-bottom: 20px;">
                Thank you for registering with Smart Barangay! 
            </p>

            <p style="color: #666; line-height: 1.6; margin-bottom: 20px;">
                We've sent a verification email to your registered email address. 
                Please check your inbox and click the verification link to complete your registration.
            </p>

            <div style="background: #f8f9fa; border-left: 4px solid #FA812F; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
                <p style="margin: 0; color: #666; font-size: 14px;">
                    <strong>Didn't receive the email?</strong><br>
                    Check your spam or junk folder. If it's not there, you can request a new verification email after logging in.
                </p>
            </div>

            <p style="color: #999; font-size: 13px; margin-bottom: 20px;">
                The verification link will expire in 24 hours.
            </p>

            <hr style="border: none; border-top: 1px solid #ddd; margin: 30px 0;">

            <h3 style="font-size: 16px; margin-bottom: 20px; color: #333;">Didn't receive the email?</h3>

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Enter your email address:</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn" style="background-color: #FA812F; color: white; width: 100%;">Resend Verification Email</button>
            </form>

            <hr style="border: none; border-top: 1px solid #ddd; margin: 30px 0;">

            <p style="margin: 0;">
                <a href="{{ route('login') }}" style="color: #FA812F; text-decoration: none; font-weight: 500;">
                    Go to Login Page
                </a>
            </p>
        </div>

        <div style="background: #f8f9fa; padding: 20px; text-align: center; border-radius: 0 0 8px 8px; border-top: 1px solid #ddd;">
            <p style="margin: 0; color: #999; font-size: 12px;">
                Smart Barangay - Document Management System<br>
                © {{ date('Y') }} All rights reserved.
            </p>
        </div>
    </div>
</div>
@endsection
