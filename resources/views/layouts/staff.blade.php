<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name') . ' - Staff')</title>

    @vite(['resources/css/app.css', 'resources/js/admin.js', 'resources/js/app.js'])
    <?php
        $manifestPath = public_path('build/manifest.json');
        if (file_exists($manifestPath)) {
            try {
                $manifest = json_decode(file_get_contents($manifestPath), true);
                if (is_array($manifest)) {
                    if (isset($manifest['resources/css/app.css']['file'])) {
                        echo '<link rel="stylesheet" href="' . asset('build/' . $manifest['resources/css/app.css']['file']) . '">';
                    }
                    if (isset($manifest['resources/js/app.js']['file'])) {
                        echo '<script type="module" src="' . asset('build/' . $manifest['resources/js/app.js']['file']) . '"></script>';
                    }
                }
            } catch (\Exception $e) {
                // ignore
            }
        }
    ?>
</head>
<body>
    <div class="admin-shell">
        <aside class="admin-sidebar" id="sidebar" style="background-color: #FA812F;">
            <a href="{{ route('staff.dashboard') }}" class="logo">
                <img src="{{ asset('images/logo2.png') }}" alt="Barangay EASE" style="max-width: 90%; height: auto;">
            </a>
            <nav>
                <a href="{{ route('staff.dashboard') }}" class="nav-link {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('staff.requests') }}" class="nav-link {{ request()->routeIs('staff.requests*') ? 'active' : '' }}">Request Queue</a>
                <a href="{{ route('staff.resident.search') }}" class="nav-link {{ request()->routeIs('staff.resident.search*') ? 'active' : '' }}">Resident Search</a>
                <a href="{{ route('staff.profile') }}" class="nav-link {{ request()->routeIs('staff.profile*') ? 'active' : '' }}">Settings</a>
            </nav>
        </aside>

        <main class="admin-main">
            <div class="topbar">
                <a href="{{ route('home') }}" class="btn btn-sm btn-light me-2" style="font-weight:600;">Home</a>
                
                <div class="dropdown ms-auto">
                    <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="staffDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border-color:rgba(255,255,255,0.2);">
                        {{ auth()->user()->full_name ?? auth()->user()->first_name ?? auth()->user()->email }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="staffDropdown">
                        <li><a class="dropdown-item" href="{{ route('staff.dashboard') }}">Dashboard</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>