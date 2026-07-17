<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - LearnLink Institute</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

    <div class="auth-wrapper">
        
        <!-- Left Side: Flat Login Form Area -->
        <div class="auth-form-column">
            
            <!-- Logo and Header -->
            <div class="auth-header">
                <div class="auth-brand-logo">
                    <img src="{{ asset('logos/logo.jpeg') }}" alt="LearnLink Institute Logo">
                </div>
                <h1>LearnLink Institute</h1>
                <p>Sign in to access your administrative workspace.</p>
            </div>

            <div>
                <!-- Professional Alert Error Block -->
                @if ($errors->any())
                    <div class="auth-alert">
                        <div class="auth-alert-title">
                            <svg style="width: 16px; height: 16px; flex-shrink: 0;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <span>Security Alert</span>
                        </div>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Flat Login Form -->
                <form method="POST" action="{{ route('login') }}" class="auth-form">
                    @csrf
                    
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
                            autofocus
                        >
                    </div>

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

                    <div class="form-options">
                        <label class="remember-me">
                            <input type="checkbox" name="remember">
                            <span>Keep me signed in</span>
                        </label>
                        
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary" style="padding: 11px; font-size: 13px; font-weight: 700; width: 100%; border-radius: 6px; margin-top: 8px;">
                        Sign In to Workspace
                    </button>
                </form>
            </div>

            <!-- Footer Details aligned flat inside column -->
            <footer class="auth-footer">
                <div>&copy; {{ date('Y') }} LearnLink Institute. All rights reserved.</div>
                <div style="margin-top: 4px;">
                    <a href="#">Terms of Service</a> &middot; <a href="#">Privacy Policy</a>
                </div>
            </footer>
        </div>

        <!-- Right Side: Clean Enterprise Brand Visual Panel -->
        <div class="auth-visual-column">
            <!-- Dynamic placeholder background picture. Update path as needed -->
            <img src="{{ asset('logos/login-hero.jpg') }}" alt="Academic Campus" class="auth-hero-image">
            
            <!-- Overlay visual description -->
            <div class="auth-visual-content">
                <span class="visual-badge">Accredited</span>
                <h2>Training That Links to Results.</h2>
                <p>Configure seamless curriculums through our high-performance academic engine dashboard.</p>
            </div>
        </div>

    </div>

</body>
</html>