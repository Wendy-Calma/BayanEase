# Email Verification Testing Guide

## Quick Test Flow

### Step 1: Register a New Account
1. Go to: `http://localhost:8000/register`
2. Fill in all 27 required fields:
   - **Full Name**: Surname, First Name, Middle Name, Nick Name
   - **Date of Birth**: Month, Day, Year
   - **Place of Birth**: Province, City
   - **Personal Info**: Citizenship, Gender, Civil Status, Religion, Education/Occupation
   - **Contact**: Phone Number, Email
   - **Family**: Spouse Name, Father Name, Mother Name
   - **Address & Residency**: Complete Address, Residency Type, Residency Years
   - **Documents**: ID Picture (JPG/PNG, max 5MB), Digital Signature (JPG/PNG, max 5MB)
   - **Credentials**: Password, Confirm Password, Accept Terms
3. Click "Register"

### Step 2: Check Verification Notice
- You should see: "Registration successful! Please check your email to verify your account."
- Page: `/verify-email`
- You'll see:
  - Instructions about verification email
  - "Resend Verification Email" form
  - Link to Login Page

### Step 3: Check Email
- Email sent from: `esguerrajustine0728@gmail.com`
- Email subject: "Verify Your Email Address - Smart Barangay"
- Email contains:
  - Welcome message
  - Orange "Verify Email Address" button
  - Direct link in case button doesn't work
  - 24-hour expiration notice

### Step 4: Click Verification Link
1. Click the verification button or link in email
2. You'll be taken to: `/verify-email/{id}/{hash}`
3. Route will:
   - Validate the link
   - Update database: `email_verified_at = current timestamp`
   - Log you in automatically
   - Redirect to dashboard
4. You should see: "Email verified successfully! Welcome to Smart Barangay."

### Step 5: Access Dashboard
- You're now logged in and can access: `/dashboard`
- You have full access to:
  - Document requests
  - Request tracking
  - Notifications
  - Profile settings

---

## Testing Scenarios

### Scenario A: Valid Email Verification
1. Register with: `user@example.com`
2. Check email, click verification link
3. **Expected**: Auto-login, redirect to dashboard, success message

### Scenario B: Invalid Verification Link
1. Register with: `test@example.com`
2. Manually modify verification link (change ID or hash)
3. Try to access modified link
4. **Expected**: Error message "Invalid verification link"
5. **Redirect to**: `/verify-email` (verification notice)

### Scenario C: Already Verified User
1. Register with: `already@example.com`
2. Complete verification (verify email successfully)
3. Try to access same verification link again
4. **Expected**: Message "Email already verified. Please log in."
5. **Redirect to**: Login page

### Scenario D: Unverified User Accessing Dashboard
1. Register with: `unverified@example.com`
2. Do NOT click verification link
3. Try to access: `/dashboard` directly
4. **Expected**: Redirect to `/verify-email` with message
5. **Message**: "Please verify your email address before accessing the dashboard"

### Scenario E: Resend Verification Email
1. Register with: `resend@example.com`
2. On verification notice page, enter email: `resend@example.com`
3. Click "Resend Verification Email"
4. **Expected**: Message "Verification email sent! Please check your inbox."
5. **Result**: New verification email arrives with same link

### Scenario F: Resend to Non-existent Email
1. On verification notice page, enter: `nonexistent@example.com`
2. Click "Resend Verification Email"
3. **Expected**: Error "No account found with this email address."

### Scenario G: Resend to Already Verified Email
1. Register and verify email successfully
2. On verification notice page, enter same email
3. Click "Resend Verification Email"
4. **Expected**: Message "This email address has already been verified."

---

## Database Verification

### Check Email Verification Status
```sql
-- View user's verification status
SELECT id, email, email_verified_at, created_at FROM users WHERE email = 'test@example.com';

-- Find unverified users
SELECT id, email, created_at FROM users WHERE email_verified_at IS NULL;

-- Find verified users
SELECT id, email, email_verified_at FROM users WHERE email_verified_at IS NOT NULL;
```

---

## Email Content Verification

### Expected Email Structure
- **From**: esguerrajustine0728@gmail.com
- **Subject**: Verify Your Email Address - Smart Barangay
- **Body**:
  ```
  Welcome to Smart Barangay!
  
  Hi [First Name],
  
  Thank you for registering! Please verify your email address to complete your registration.
  
  [VERIFY EMAIL ADDRESS] (button)
  
  Or copy and paste this link: https://yoursite.com/verify-email/{id}/{hash}
  
  The verification link will expire in 24 hours.
  
  ---
  Smart Barangay - Document Management System
  © 2024 All rights reserved.
  ```

---

## Troubleshooting

### Email Not Received
1. **Check spam/junk folder** - Gmail may mark it as spam initially
2. **Resend from verification page** - Click "Resend Verification Email"
3. **Check .env configuration**:
   ```
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=esguerrajustine0728@gmail.com
   MAIL_PASSWORD=azfu qqte duyb sbfg
   MAIL_ENCRYPTION=tls
   ```
4. **Check application logs**: `storage/logs/laravel.log`

### User Can't Verify Email
1. **Invalid link**: Make sure link wasn't modified
2. **Already verified**: Check database for `email_verified_at`
3. **Wrong email**: Make sure email matches registration email

### User Locked Out of Dashboard
1. Verify `email_verified_at` is set in database
2. Check if middleware is applied to route
3. Clear browser cache and session
4. Try different browser or incognito mode

---

## Important Routes Reference

| Route | Method | Purpose | Middleware |
|-------|--------|---------|------------|
| `/register` | GET | Show registration form | guest |
| `/register` | POST | Process registration | guest |
| `/verify-email` | GET | Show verification notice | guest |
| `/verify-email/{id}/{hash}` | GET | Validate email & auto-login | guest |
| `/verify-email/resend` | POST | Resend verification email | guest |
| `/dashboard` | GET | Access dashboard | auth, verified |
| `/login` | GET | Show login form | guest |
| `/logout` | POST | Logout user | auth |

---

## Key Code Locations

- **Registration Route**: `/routes/web.php` (lines 93-227)
- **Verification Routes**: `/routes/web.php` (lines 228-254)
- **Email Middleware**: `/app/Http/Middleware/EnsureEmailIsVerified.php`
- **Mailable Class**: `/app/Mail/VerifyEmailMail.php`
- **Email Template**: `/resources/views/emails/verify-email.blade.php`
- **Verification Notice View**: `/resources/views/auth/verify-email.blade.php`
- **User Model Casts**: `/app/Models/User.php` (line 53)
- **Kernel Middleware**: `/app/Http/Kernel.php` (line 66)
- **Email Configuration**: `/.env` (lines 31-37)

---

## Success Indicators

✅ Email received from `esguerrajustine0728@gmail.com`
✅ Verification link works and contains correct ID and hash
✅ After clicking link: redirected to dashboard
✅ Database updated with `email_verified_at` timestamp
✅ Unverified users cannot access dashboard
✅ Resend email feature works correctly
✅ Error messages display for invalid links
✅ No errors in `storage/logs/laravel.log`

---

## Next Actions After Verification Works

1. **Test all registration fields** - Ensure all 27 fields save correctly
2. **Test file uploads** - Check ID picture and digital signature upload to correct directories
3. **Test dashboard access** - Verified users should have full dashboard access
4. **Test profile view/edit** - My Profile page should display all information
5. **Test password reset** - If applicable, verify password reset flow
6. **Stress test** - Try rapid registrations to ensure email queue doesn't fail
