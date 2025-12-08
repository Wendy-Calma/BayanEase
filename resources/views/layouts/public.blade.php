<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Smart Barangay')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
                <img src="{{ asset('images/logo.png') }}" alt="Barangay EASE" style="height: 50px; width: auto;">
            </a>
            <div class="navbar-nav ms-auto">
                @guest
                    <a class="nav-link" href="{{ route('login') }}" style="color: #4A5568; font-weight: 500; margin-right: 15px;">Login</a>
                    <a class="btn" href="{{ route('register') }}" style="background-color: #FA812F; color: white; border: none; padding: 8px 25px; font-weight: 600; border-radius: 6px; text-decoration: none;">Get Started</a>
                @else
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

    <main class="container" style="margin-top: 0; padding-top: 0;">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer style="background-color: #1a2332; color: #a0aec0; padding: 60px 20px 20px;">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px; margin-bottom: 40px;">
                <!-- Smart Barangay Section -->
                <div>
                    <h3 style="color: #FA812F; font-weight: 700; font-size: 16px; margin-bottom: 20px;">Bayan EASE</h3>
                    <p style="line-height: 1.6; font-size: 14px; color: #cbd5e0;">Making barangay services accessible, efficient, and transparent for all residents.</p>
                </div>

                <!-- Quick Links Section -->
                <div>
                    <h3 style="color: #FA812F; font-weight: 700; font-size: 16px; margin-bottom: 20px;">Quick Links</h3>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="margin-bottom: 10px;"><a href="#" style="color: #a0aec0; text-decoration: none; font-size: 14px;">Features</a></li>
                        <li style="margin-bottom: 10px;"><a href="#" style="color: #a0aec0; text-decoration: none; font-size: 14px;">How it Works</a></li>
                        <li style="margin-bottom: 10px;"><a href="#" style="color: #a0aec0; text-decoration: none; font-size: 14px;">Available Documents</a></li>
                        <li style="margin-bottom: 10px;"><a href="{{ route('register') }}" style="color: #a0aec0; text-decoration: none; font-size: 14px;">Register</a></li>
                    </ul>
                </div>

                <!-- Support Section -->
                <div>
                    <h3 style="color: #FA812F; font-weight: 700; font-size: 16px; margin-bottom: 20px;">Support</h3>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="margin-bottom: 10px;"><a href="#" style="color: #a0aec0; text-decoration: none; font-size: 14px;">FAQ</a></li>
                        <li style="margin-bottom: 10px;"><a href="#" style="color: #a0aec0; text-decoration: none; font-size: 14px;">Help Center</a></li>
                        <li style="margin-bottom: 10px;"><a href="#" style="color: #a0aec0; text-decoration: none; font-size: 14px;">Privacy Policy</a></li>
                        <li style="margin-bottom: 10px;"><a href="#" style="color: #a0aec0; text-decoration: none; font-size: 14px;">Terms of Service</a></li>
                    </ul>
                </div>

                <!-- Contact Us Section -->
                <div>
                    <h3 style="color: #FA812F; font-weight: 700; font-size: 16px; margin-bottom: 20px;">Contact Us</h3>
                    <div style="font-size: 14px; line-height: 1.8;">
                        <div style="display: flex; align-items: flex-start; margin-bottom: 12px;">
                            <span style="margin-right: 10px; color: #FA812F;">📍</span>
                            <span>Barangay Hall, Angeles City</span>
                        </div>
                        <div style="display: flex; align-items: flex-start; margin-bottom: 12px;">
                            <span style="margin-right: 10px; color: #FA812F;">📱</span>
                            <span>(+63) 123-456-7891</span>
                        </div>
                        <div style="display: flex; align-items: flex-start; margin-bottom: 12px;">
                            <span style="margin-right: 10px; color: #FA812F;">✉️</span>
                            <span>info@smartbarangay.gov.ph</span>
                        </div>
                        <div style="display: flex; align-items: flex-start;">
                            <span style="margin-right: 10px; color: #FA812F;">🕐</span>
                            <span>Mon-Fri: 8:00 AM - 5:00 PM</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div style="border-top: 1px solid #2d3748; padding-top: 20px; text-align: center; color: #718096; font-size: 14px;">
                <p style="margin: 0;">&copy; {{ date('Y') }} Bayan EASE. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>