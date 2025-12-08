<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group.
|
*/

// Home page (uses the new home view)
Route::get('/', function () {
    return view('home');
})->name('home');

// Temporary debug route (only available when APP_DEBUG=true) to quickly test dashboard rendering
if (env('APP_DEBUG')) {
    Route::get('/_debug_dashboard', function () {
        return view('dashboard');
    })->name('_debug_dashboard');

    // Debug assets and current user role
    Route::get('/_debug_assets', function () {
        $manifestPath = public_path('build/manifest.json');
        $manifest = file_exists($manifestPath) ? json_decode(file_get_contents($manifestPath), true) : null;

        $files = [];
        if (is_array($manifest)) {
            foreach ($manifest as $key => $entry) {
                $files[$key] = [
                    'file' => $entry['file'] ?? null,
                    'exists' => isset($entry['file']) ? file_exists(public_path('build/' . $entry['file'])) : false,
                ];
            }
        }

        return response()->json([
            'user' => auth()->check() ? ['id' => auth()->id(), 'role' => auth()->user()->role->name ?? null] : null,
            'manifest_exists' => file_exists($manifestPath),
            'manifest' => $manifest ? array_keys($manifest) : null,
            'files' => $files,
            'build_path' => public_path('build'),
        ]);
    })->name('_debug_assets');
}

// Login form (GET)
Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');

// Login submit (POST)
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate();
        // Redirect based on user role: admin to admin dashboard, staff to staff dashboard, residents to user dashboard
        $user = auth()->user();
        if ($user && $user->role) {
            if ($user->role->name === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->role->name === 'staff') {
                return redirect()->intended('/staff/dashboard');
            }
        }

        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
})->middleware('guest')->name('login.attempt');

// Registration form (GET)
Route::get('/register', function () {
    return view('auth.register');
})->middleware('guest')->name('register');

// Registration submit (POST)
Route::post('/register', function (Request $request) {
    try {
        \Log::info('Registration attempt starting', [
            'request_data' => $request->except('password', 'password_confirmation'),
            'request_method' => $request->method(),
            'form_data' => $request->all()
        ]);
        
        $data = $request->validate([
            // Full Name
            'surname' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'required|string|max:255',
            'nick_name' => 'nullable|string|max:255',
            
            // Date of Birth
            'birth_month' => 'required|string|max:2',
            'birth_day' => 'required|numeric|min:1|max:31',
            'birth_year' => 'required|numeric|min:1900|max:' . date('Y'),
            
            // Place of Birth
            'birth_province' => 'required|string|max:255',
            'birth_city' => 'required|string|max:255',
            
            // Personal Information
            'citizenship' => 'required|string|max:255',
            'gender' => 'required|string',
            'civil_status' => 'required|string',
            'religion' => 'required|string|max:255',
            'education_occupation' => 'required|string|max:255',
            
            // Contact
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:users,email',
            
            // Family Information
            'spouse_name' => 'nullable|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            
            // Address & Residency
            'complete_address' => 'required|string|max:1000',
            'residency_type' => 'required|string',
            'residency_years' => 'required|numeric|min:0',
            
            // Documents
            'id_picture' => 'required|file|mimes:jpeg,png|max:5120',
            'digital_signature' => 'required|file|mimes:jpeg,png|max:5120',
            
            // Credentials
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
            'terms' => 'required|accepted',
        ], [
            'gender.required' => 'Gender is required',
            'civil_status.required' => 'Civil status is required',
            'residency_type.required' => 'Residency type is required',
            'password.confirmed' => 'Passwords do not match',
            'email.unique' => 'This email is already registered',
            'id_picture.required' => 'ID picture is required',
            'digital_signature.required' => 'Digital signature is required',
        ]);

        // Handle file uploads
        $idPicturePath = null;
        $digitalSignaturePath = null;
        
        if ($request->hasFile('id_picture')) {
            $idPicturePath = $request->file('id_picture')->store('public/uploads/id_pictures');
            \Log::info('ID picture uploaded', ['path' => $idPicturePath]);
        }
        
        if ($request->hasFile('digital_signature')) {
            $digitalSignaturePath = $request->file('digital_signature')->store('public/uploads/digital_signatures');
            \Log::info('Digital signature uploaded', ['path' => $digitalSignaturePath]);
        }

        // Get default resident role
        $residentRole = \App\Models\Role::where('name', 'resident')->first();
        if (!$residentRole) {
            \Log::error('Resident role not found in database');
            return back()->withErrors(['error' => 'System roles not set up properly.'])->withInput();
        }

        \Log::info('Creating user with data:', ['email' => $data['email']]);
        
        $user = User::create([
            'role_id' => $residentRole->id,
            'surname' => $data['surname'],
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'],
            'last_name' => $data['surname'], // For backward compatibility
            'nick_name' => $data['nick_name'] ?? null,
            'birth_month' => $data['birth_month'],
            'birth_day' => $data['birth_day'],
            'birth_year' => $data['birth_year'],
            'birth_province' => $data['birth_province'],
            'birth_city' => $data['birth_city'],
            'citizenship' => $data['citizenship'],
            'gender' => $data['gender'],
            'civil_status' => $data['civil_status'],
            'religion' => $data['religion'],
            'education_occupation' => $data['education_occupation'],
            'phone_number' => $data['phone_number'],
            'email' => $data['email'],
            'spouse_name' => $data['spouse_name'] ?? null,
            'father_name' => $data['father_name'],
            'mother_name' => $data['mother_name'],
            'complete_address' => $data['complete_address'],
            'residency_type' => $data['residency_type'],
            'residency_years' => $data['residency_years'],
            'id_picture' => $idPicturePath,
            'digital_signature' => $digitalSignaturePath,
            'password' => Hash::make($data['password']),
            'is_active' => true,
        ]);

        \Log::info('User created successfully', ['user_id' => $user->id]);

        // Send verification email (non-blocking)
        try {
            $verificationUrl = route('verification.verify', [
                'id' => $user->id,
                'hash' => sha1($user->email)
            ]);
            \Mail::to($user->email)->send(new \App\Mail\VerifyEmailMail($user, $verificationUrl));
            \Log::info('Verification email sent', ['user_id' => $user->id]);
        } catch (\Throwable $e) {
            \Log::error('Failed to send verification email', ['error' => $e->getMessage()]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Registration successful! Please check your email to verify your account.',
            'redirect' => route('verification.notice')
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        \Log::error('Validation failed', [
            'errors' => $e->errors(),
        ]);
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $e->errors()
        ], 422);
    } catch (\Throwable $e) {
        \Log::error('Registration failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return back()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()])->withInput();
    }
})->middleware('guest')->name('register.submit');

// Email Verification Routes
Route::get('/verify-email', function () {
    return view('auth.verify-email');
})->middleware('guest')->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = \App\Models\User::find($id);

    if (!$user || sha1($user->email) !== $hash) {
        return redirect()->route('verification.notice')->withErrors(['email' => 'Invalid verification link.']);
    }

    if ($user->email_verified_at) {
        return redirect()->route('login')->with('success', 'Email already verified. Please log in.');
    }

    $user->update(['email_verified_at' => now()]);

    Auth::login($user);
    $request->session()->regenerate();

    return redirect()->intended('/dashboard')->with('success', 'Email verified successfully! Welcome to Smart Barangay.');
})->middleware('guest')->name('verification.verify');

Route::post('/verify-email/resend', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $user = \App\Models\User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'No account found with this email address.']);
    }

    if ($user->email_verified_at) {
        return back()->with('info', 'This email address has already been verified.');
    }

    try {
        $verificationUrl = route('verification.verify', [
            'id' => $user->id,
            'hash' => sha1($user->email)
        ]);
        \Mail::send(new \App\Mail\VerifyEmailMail($user, $verificationUrl));
        return back()->with('success', 'Verification email sent! Please check your inbox.');
    } catch (\Exception $e) {
        \Log::error('Failed to resend verification email', ['error' => $e->getMessage()]);
        return back()->withErrors(['error' => 'Failed to send verification email. Please try again later.']);
    }
})->middleware('guest')->name('verification.send');

// Logout (POST)
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('home');
})->middleware('auth')->name('logout');

// Dashboard Routes
Route::middleware(['auth'])->group(function () {
    // Staff Routes
    Route::middleware(['role:staff'])->prefix('staff')->name('staff.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Staff\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/requests', [App\Http\Controllers\Staff\RequestController::class, 'index'])->name('requests');
        Route::get('/requests/{id}', [App\Http\Controllers\Staff\RequestController::class, 'show'])->name('requests.show');
        Route::post('/requests/{id}', [App\Http\Controllers\Staff\RequestController::class, 'update'])->name('requests.update');
        Route::get('/resident-search', [App\Http\Controllers\Staff\ResidentSearchController::class, 'index'])->name('resident.search');
        Route::get('/profile', [App\Http\Controllers\Staff\ProfileController::class, 'index'])->name('profile');
        Route::put('/profile', [App\Http\Controllers\Staff\ProfileController::class, 'update'])->name('profile.update');
    });

    // Admin Routes
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // User Management Routes
        Route::resource('users', App\Http\Controllers\Admin\UserManagementController::class);
        
        // Staff Management
        Route::resource('staff', App\Http\Controllers\Admin\StaffManagementController::class);
        
        // Document Management
        Route::resource('documents', App\Http\Controllers\Admin\DocumentManagementController::class);
        
        // Reports & Logs
        Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
        
        // Admin Settings
        Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
        
        // Audit Trail
        Route::get('/audit-trail', [App\Http\Controllers\Admin\AuditTrailController::class, 'index'])->name('audit.index');
        
        Route::get('/requests', function () {
            return view('admin.requests.index');
        })->name('requests');

        // API: dashboard data
        Route::get('/api/dashboard/monthly-requests', [App\Http\Controllers\Admin\DashboardController::class, 'monthlyRequests'])->name('api.dashboard.monthly_requests');
    });

    // Public API endpoint for dashboard charts (returns per-user data for non-admins)
    Route::get('/api/dashboard/monthly-requests', [App\Http\Controllers\DashboardController::class, 'monthlyRequests'])->name('api.dashboard.monthly_requests');

    // Resident/User Dashboard and routes (for users who are NOT staff or admin)
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Document Request Routes
    Route::get('/document/request', [App\Http\Controllers\DocumentRequestController::class, 'create'])->name('document.request');
    Route::post('/document/request', [App\Http\Controllers\DocumentRequestController::class, 'store'])->name('document.request.store');
    
    // Dependent Routes
    Route::post('/dependent', [App\Http\Controllers\DependentController::class, 'store'])->name('dependent.store');
    Route::delete('/dependent/{dependent}', [App\Http\Controllers\DependentController::class, 'destroy'])->name('dependent.destroy');
    
    // Request Tracking Routes
    Route::get('/request/track', [App\Http\Controllers\RequestTrackingController::class, 'index'])->name('request.track');
    Route::get('/request/{request}/track', [App\Http\Controllers\RequestTrackingController::class, 'show'])->name('request.track.show');
    Route::post('/request/{request}/cancel', [App\Http\Controllers\RequestTrackingController::class, 'cancel'])->name('request.cancel');

    // Notifications
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/{id}/mark-as-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');

    // User Settings
    Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings');
    Route::put('/settings/profile', [App\Http\Controllers\SettingsController::class, 'updateProfile'])->name('settings.profile.update');
    Route::put('/settings/password', [App\Http\Controllers\SettingsController::class, 'updatePassword'])->name('settings.password.update');
});

