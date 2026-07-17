<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify Code - LearnLink Institute</title>
    <!-- Reusing your unified login.css stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

    <!-- Centering the single wrapper column horizontally on the screen -->
    <div class="auth-wrapper" style="justify-content: center;">
        
        <!-- Centering the content vertically and making it a flat full-height column -->
        <div class="auth-form-column" style="height: 100vh; justify-content: center; gap: 28px;">
            
            <!-- Logo and Header -->
            <div class="auth-header" style="margin-top: 0; margin-bottom: 8px;">
                <div class="auth-brand-logo">
                    <img src="{{ asset('logos/logo.jpeg') }}" alt="LearnLink Institute Logo">
                </div>
                <h1>Enter Security Code</h1>
                <p style="margin-top: 8px; line-height: 1.5;">
                    Please enter the secure 6-digit verification code sent to:<br>
                    <strong style="color: var(--primary-blue); font-size: 13.5px;">{{ session('masked', 'your registered contact') }}</strong>
                </p>
            </div>

            <div>
                <!-- Professional Alert: Error Block -->
                @if ($errors->any())
                    <div class="auth-alert">
                        <div class="auth-alert-title">
                            <svg style="width: 16px; height: 16px; flex-shrink: 0;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <span>Invalid Code</span>
                        </div>
                        <p style="margin-top: 2px; font-size: 11.5px;">{{ $errors->first() }}</p>
                    </div>
                @endif

                <!-- Flat Verification Code Form -->
                <form method="POST" action="{{ route('verify.code.submit') }}" class="auth-form">
                    @csrf
                    
                    <!-- Code Input Group -->
                    <div class="form-group">
                        <label for="code">6-Digit Verification Code</label>
                        <input 
                            type="text" 
                            name="code" 
                            id="code" 
                            class="input-control" 
                            placeholder="123456" 
                            maxlength="6"
                            pattern="[0-9]*"
                            inputmode="numeric"
                            style="text-align: center; font-size: 18px; letter-spacing: 6px; font-weight: 700;"
                            required 
                            autofocus
                        >
                    </div>

                    <!-- Submit Action Button -->
                    <button type="submit" class="btn-submit">
                        Verify Code
                    </button>

                    <!-- Back to Login Navigation Option -->
                    <div class="form-options" style="justify-content: center; margin-top: 16px;">
                        <span style="color: var(--text-muted);">Entered the wrong address?</span>
                        <a href="{{ route('login') }}" class="forgot-link" style="margin-left: 6px;">Return to Sign In</a>
                    </div>
                </form>
            </div>

            <!-- Flat footer styled inside the column -->
            <footer class="auth-footer" style="margin-top: 0;">
                <div>&copy; {{ date('Y') }} LearnLink Institute. All rights reserved.</div>
                <div style="margin-top: 4px;">
                    <a href="#">Terms of Service</a> &middot; <a href="#">Privacy Policy</a>
                </div>
            </footer>
        </div>

    </div>

</body>
</html>