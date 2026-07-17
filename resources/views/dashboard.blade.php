<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnLink Institute - Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>

    <div class="dashboard-wrapper">
        
        <!-- Sidebar Drawer Overlay (Triggers close <= 400px) -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Left Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="brand-logo">
                    <img src="{{ asset('logos/logo.jpeg') }}" alt="LearnLink Institute Logo" style="width: 80px; height: 80px; object-fit: cover;">
                </div>
                <div class="brand-name">LearnLink Institute</div>
            </div>
            
            <nav class="sidebar-nav">
                <!-- Home/Dashboard active -->
                <a href="#" class="nav-item active">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Home / Dashboard
                </a>
                
                <!-- Manage Courses Link -->
                <a href="{{ route('admin.courses.index') }}" class="nav-item">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    Manage Courses
                </a>
                
                <!-- Manage Students Link -->
                <a href="{{ route('admin.students.index') }}" class="nav-item">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Manage Students
                </a>
                
                <!-- Manage Instructors Link -->
                <a href="{{ route('instructors.index') }}" class="nav-item">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Manage Instructors
                </a>
            </nav>
            
            <!-- Sidebar Footer -->
            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}" class="logout-form-wrapper">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
                
                <div class="footer-meta">
                    <a href="#">Terms & Conditions</a> · <a href="#">Privacy</a>
                    <div style="margin-top: 4px;">Version 1.0.208</div>
                </div>
            </div>
        </aside>

        <!-- Main Workspace -->
        <main class="main-content">
            
            <!-- Top Navbar Area -->
            <header class="top-nav">
                <!-- Hamburger menu button visible only at <= 400px -->
                <button class="menu-toggle-btn" id="menuToggle" aria-label="Toggle Navigation Menu">
                    <svg style="width: 22px; height: 22px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <div class="user-profile-badge">
                    <div class="user-avatar">
                        {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                    </div>
                    <span>{{ auth()->user()->name ?? 'Admin' }}</span>
                </div>
            </header>

            <!-- Container Body -->
            <div class="content-container">

                <!-- Notifications Panel -->
                @if(session('success')) 
                    <div class="alert alert-success">
                        <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                @elseif ($errors->any()) 
                    <div class="alert alert-danger">
                        <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $errors->first() }}
                    </div>
                @endif  

                <!-- Page Header Greeting -->
                <div class="welcome-header">
                    <h2>Welcome, {{ auth()->user()->name ?? 'Admin' }}</h2>
                    <p>Manage and monitor your institution's registration, course catalog, and active user accounts.</p>
                </div>

                <!-- Hero Section Panel -->
                <div class="hero-card">
                    <div class="hero-left">
                        <span class="hero-tag">Active Academic Session</span>
                        <div class="hero-title">
                            <h3>Institution Quick Configuration Panel</h3>
                            <p>Configure institutional rules, track active student rosters, and run program analytics.</p>
                        </div>
                        <div class="hero-actions">
                            <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">Create Program</a>
                            <a href="{{ route('admin.students.create') }}" class="btn btn-success">Enroll Student</a>
                        </div>
                    </div>
                    
                    <div class="hero-right">
                        <!-- Custom system graphic matching SHA image aesthetic -->
                        <svg style="width: 140px; height: auto; opacity: 0.85;" viewBox="0 0 200 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="100" cy="50" r="40" stroke="#033b66" stroke-width="2" stroke-dasharray="5 5"/>
                            <path d="M70 50h60M100 20v60" stroke="#a80027" stroke-width="2"/>
                        </svg>
                    </div>
                </div>

                <!-- Insightful Metric Grid Area (Courses, Students, Instructors) -->
                <div class="dashboard-grid">
                    
                    <!-- Card: Total Courses Registered -->
                    <div class="grid-card">
                        <div>
                            <div class="card-header-row">
                                <h4>Courses Catalog</h4>
                                <a href="{{ route('admin.courses.index') }}" class="btn-link">Manage</a>
                            </div>
                            <div class="card-subtitle">Active classes & curriculum paths</div>
                        </div>
                        
                        <div class="card-metric-container">
                            <div class="metric-value-box">
                                <span class="metric-number">{{ $coursesCount ?? '24' }}</span>
                                <span class="metric-label">Active Courses</span>
                            </div>
                            <div class="metric-icon-box">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="card-footer-actions">
                            <a href="{{ route('admin.courses.create') }}" class="btn btn-outline">+ Register New Course</a>
                        </div>
                    </div>

                    <!-- Card: Registered Students -->
                    <div class="grid-card">
                        <div>
                            <div class="card-header-row">
                                <h4>Student Roster</h4>
                                <a href="{{ route('admin.students.index') }}" class="btn-link">Manage</a>
                            </div>
                            <div class="card-subtitle">Enrolled students in the system</div>
                        </div>

                        <div class="card-metric-container">
                            <div class="metric-value-box">
                                <span class="metric-number">{{ $studentsCount ?? '1,420' }}</span>
                                <span class="metric-label">Enrolled Students</span>
                            </div>
                            <div class="metric-icon-box">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="card-footer-actions">
                            <a href="{{ route('admin.students.create') }}" class="btn btn-outline">+ Enroll New Student</a>
                        </div>
                    </div>

                    <!-- Card: Total Instructors (System Users) -->
                    <div class="grid-card">
                        <div>
                            <div class="card-header-row">
                                <h4>Faculty Members</h4>
                                <a href="{{ route('instructors.index') }}" class="btn-link">Manage</a>
                            </div>
                            <div class="card-subtitle">Active academic instructors</div>
                        </div>

                        <div class="card-metric-container">
                            <div class="metric-value-box">
                                <span class="metric-number">{{ $instructorsCount ?? '48' }}</span>
                                <span class="metric-label">Active Instructors</span>
                            </div>
                            <div class="metric-icon-box">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="card-footer-actions">
                            <a href="{{ route('instructors.index') }}" class="btn btn-outline">Configure Directory</a>
                        </div>
                    </div>

                </div> <!-- End Grid -->

            </div> <!-- End Content Container -->
        </main>
    </div>

    <!-- Toggle Controller Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            const toggleSidebar = () => {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            };

            menuToggle.addEventListener('click', toggleSidebar);
            overlay.addEventListener('click', toggleSidebar);
        });
    </script>
</body>
</html>