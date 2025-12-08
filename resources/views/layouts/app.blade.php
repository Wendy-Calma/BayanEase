<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@yield('title', 'Smart Barangay - Dashboard')</title>
	@vite(['resources/css/app.css', 'resources/js/app.js'])

	{{-- Fallback: if Vite manifest exists and for some reason @vite didn't print links (e.g. certain runtime),
		 output direct links to the built files from public/build/manifest.json -- helps when debugging CSS not loading. --}}
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
				// If manifest can't be parsed, ignore fallback silently
			}
		}
	?>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container">
			<a class="navbar-brand" href="{{ url('/') }}" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
				<img src="{{ asset('images/logo.png') }}" alt="Barangay EASE" style="height: 50px; width: auto;">
			</a>
			<div class="navbar-nav ms-auto">
				@guest
					<a class="nav-link" href="{{ route('login') }}">Login</a>
					<a class="btn btn-primary" href="{{ route('register') }}">Get Started</a>
				@else
					{{-- Resident quick dashboard button (visible to residents) --}}
					@if(auth()->user() && auth()->user()->hasRole('resident'))
						<a class="btn btn-outline-primary me-2" href="{{ route('dashboard') }}">Dashboard</a>
					@endif
                    
					<div class="nav-item dropdown">
						<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							{{ auth()->user()->full_name ?? auth()->user()->first_name ?? auth()->user()->email }}
						</a>
						<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
							<li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
							<li>
								<form method="POST" action="{{ route('logout') }}">
									@csrf
									<button type="submit" class="dropdown-item">Logout</button>
								</form>
							</li>
						</ul>
					</div>
				@endguest
			</div>
		</div>
	</nav>

	<main class="container mt-5">
		@yield('content')
	</main>

	@stack('scripts')
</body>
</html>
