<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register - LearnLink Institute</title>
    <!-- Reusing the dedicated login.css file for perfect consistency -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

    <div class="auth-wrapper">
        
        <!-- Left Side: Flat Registration Form Area -->
        <div class="auth-form-column">
            
            <!-- Logo and Header -->
            <div class="auth-header">
                <div class="auth-brand-logo">
                    <img src="{{ asset('logos/logo.jpeg') }}" alt="LearnLink Institute Logo">
                </div>
                <h1>Create Account</h1>
                <p>Register your credentials to set up your administrator profile.</p>
            </div>

            <div>
                <!-- Professional Security Alert Box for Registration Errors -->
                @if ($errors->any())
                    <div class="auth-alert">
                        <div class="auth-alert-title">
                            <svg style="width: 16px; height: 16px; flex-shrink: 0;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <span>Registration Blocked</span>
                        </div>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Flat Registration Form -->
                <form method="POST" action="{{ route('register') }}" class="auth-form">
                    @csrf
                    
                    <!-- Name Input -->
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            class="input-control" 
                            placeholder="e.g. Jane Doe" 
                            value="{{ old('name') }}" 
                            required 
                            autofocus
                        >
                    </div>

                    <!-- Email Input -->
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            class="input-control" 
                            placeholder="name@institution.com" 
                            value="{{ old('email') }}" 
                            required
                        >
                    </div>

                    <!-- Password Input -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="input-control" 
                            placeholder="••••••••" 
                            required
                        >
                    </div>

                    <!-- Submit Action Button -->
                    <button type="submit" class="btn-submit">
                        Register Account
                    </button>

                    <!-- Login Redirection Option -->
                    <div class="form-options" style="justify-content: center; margin-top: 16px;">
                        <span style="color: var(--text-muted);">Already have an account?</span>
                        <a href="{{ route('login') }}" class="forgot-link" style="margin-left: 6px;">Sign In</a>
                    </div>
                </form>
            </div>

            <!-- Flat Footer inside form column -->
            <footer class="auth-footer">
                <div>&copy; {{ date('Y') }} LearnLink Institute. All rights reserved.</div>
                <div style="margin-top: 4px;">
                    <a href="#">Terms of Service</a> &middot; <a href="#">Privacy Policy</a>
                </div>
            </footer>
        </div>

        <!-- Right Side: Graphic Visual Panel (Shares image with Login) -->
        <div class="auth-visual-column">
            <img src="{{ asset('logos/login-hero.jpg') }}" alt="Academic Campus" class="auth-hero-image">
            
            <!-- Overlay Content -->
            <div class="auth-visual-content">
                <span class="visual-badge">Accredited</span>
                <h2>Training That Links to Results.</h2>
                <p>Configure seamless curriculums through our high-performance academic engine dashboard.</p>
            </div>
        </div>

    </div>

</body>
</html>