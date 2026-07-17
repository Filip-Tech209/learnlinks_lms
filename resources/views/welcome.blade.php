<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Learn Link Consultancy</title>
    <!-- Pointing directly to your dedicated welcome stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body>

    <!-- Flat Top Header Navigation -->
    <header class="welcome-header">
        <div class="brand-wrapper">
            <div class="brand-logo">
                <img src="{{ asset('logos/logo.jpeg') }}" alt="Learn Link Logo">
            </div>
            <div class="brand-info">
                <span class="brand-title">Learn Link</span>
                <span class="brand-motto">Bridging Knowledge & Excellence</span>
            </div>
        </div>

        <div class="header-actions">
            <a href="{{ route('login') }}" class="btn btn-outline">Sign In</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-primary">Create Account</a>
            @endif
        </div>
    </header>

    <!-- Flat Split Hero Workspace -->
    <main class="hero-wrapper">
        
        <!-- Left Side: Copy, Greeting, and CTAs -->
        <div class="hero-content-panel">
            <span class="welcome-tag">Academic Portal v1.0</span>
            <h1>Welcome to <br><span>Learn Link Consultancy</span></h1>
            <p>We are excited to have you here! Get started on configuring custom curriculums, monitoring enrolled rosters, and assigning instructors to courses on a high-performance database workspace.</p>
            
            <div class="hero-ctas">
                <a href="{{ route('login') }}" class="btn btn-primary" style="padding: 12px 24px;">
                    Access Workspace
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline" style="padding: 12px 24px;">
                    Register Profile
                </a>
            </div>
        </div>

        <!-- Right Side: Flat Illustrative Grid (No Cards, Document Grid) -->
        <div class="hero-graphic-panel">
            <div class="graphic-block">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <span>Curriculum Catalogs</span>
            </div>
            
            <div class="graphic-block">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <span>Student Rosters</span>
            </div>

            <div class="graphic-block" style="grid-column: span 2;">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                <span style="color: var(--accent-red);">Authorized Administration Access Only</span>
            </div>
        </div>

    </main>

    <!-- Flat Contact & Meta Footer -->
    <footer class="welcome-footer">
        <div class="footer-grid">
            
            <!-- Column 1: Short About -->
            <div class="footer-about">
                <div class="footer-about-title">Learn Link Consultancy</div>
                <p>Delivering high-fidelity structural academic program analytics, curriculum design protocols, and seamless portal configurations.</p>
            </div>

            <!-- Column 2: Phone Directory -->
            <div class="contact-column">
                <span class="contact-column-title">Phone Directory</span>
                <div class="contact-item">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    <span>+254 700 000 000</span>
                </div>
                <div class="contact-item">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    <span>+254 711 111 111</span>
                </div>
            </div>

            <!-- Column 3: Communication -->
            <div class="contact-column">
                <span class="contact-column-title">Communication</span>
                <div class="contact-item">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span><a href="mailto:info@learnlinkconsultancy.com">info@learnlinkconsultancy.com</a></span>
                </div>
                <div class="contact-item">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                    </svg>
                    <span><a href="https://learnlinkconsultancy.com" target="_blank">learnlinkconsultancy.com</a></span>
                </div>
            </div>

            <!-- Column 4: Main Office -->
            <div class="contact-column">
                <span class="contact-column-title">Main Office</span>
                <div class="contact-item">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>Nairobi, Kenya</span>
                </div>
                <div class="contact-item">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span>Central Business District</span>
                </div>
            </div>

        </div>

        <div class="copyright-bar">
            <div>&copy; {{ date('Y') }} Learn Link Consultancy. All rights reserved.</div>
            <div style="display: flex; gap: 12px;">
                <a href="#" style="color: var(--text-muted); text-decoration: none;">Terms of Use</a>
                <span>&middot;</span>
                <a href="#" style="color: var(--text-muted); text-decoration: none;">Privacy Protocol</a>
            </div>
        </div>
    </footer>

</body>
</html>