<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses - LearnLink Institute</title>
    <!-- Combined layout styling with table stylesheet overrides -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/courses.css') }}">
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
                <!-- Home/Dashboard -->
                <a href="{{ route('dashboard') }}" class="nav-item">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Home / Dashboard
                </a>
                
                <!-- Manage Courses Link (Now marked active to show panel transition) -->
                <a href="{{ route('admin.courses.index') }}" class="nav-item active">
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

            <!-- Workspace Content Panel -->
            <div class="content-container">

                <!-- Notifications Alerts -->
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

                <!-- Back navigation & Breadcrumbs -->
                <div>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline" style="padding: 5px 10px; font-size: 11px; font-weight: 700; margin-bottom: 12px;">
                        &larr; Back to Dashboard
                    </a>
                </div>

                <!-- Panel Section Title -->
                <div class="panel-header-row">
                    <div class="panel-title-group">
                        <h2>Course Catalog Directory</h2>
                        <p>A central control grid to track registered programs, curriculum formats, and academic pricing models.</p>
                    </div>
                </div>

                <!-- Search and Controls Row (Integrated) -->
                <div class="table-actions-bar">
                    <div class="search-box-wrapper">
                        <!-- Custom Search Icon -->
                        <svg class="search-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" class="search-input" placeholder="Search course by code or title...">
                    </div>
                    
                    <a href="{{ route('admin.courses.create') }}" class="btn btn-success" style="font-weight: 700;">
                        + Add New Course
                    </a>
                </div>

                <!-- Table Data Display Container -->
                <div class="table-responsive-container">
                    <table class="enterprise-table">
                        <thead>
                            <tr>
                                <th style="width: 60px;">Image</th>
                                <th>Course Title</th>
                                <th>Duration</th>
                                <th>Delivery Method</th>
                                <th>Base Cost</th>
                                <th style="width: 120px; text-align: center;">Workspace Controls</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($courses as $course)
                                <tr>
                                    <!-- Image Column with neat dynamic boxes -->
                                    <td>
                                        <div class="thumbnail-box">
                                            @if($course->featured_image)
                                                <img src="{{ asset('storage/' . $course->featured_image) }}" alt="Course Art">
                                            @else
                                                <div class="thumbnail-placeholder">NO<br>ART</div>
                                            @endif
                                        </div>
                                    </td>
                                    
                                    <!-- Title Column -->
                                    <td style="font-weight: 600; color: var(--primary-blue);">
                                        {{ $course->title }}
                                    </td>
                                    
                                    <!-- Duration Column -->
                                    <td>{{ $course->duration }}</td>
                                    
                                    <!-- Delivery Method styled Status Badges -->
                                    <td>
                                        @php
                                            $method = strtolower($course->delivery_method);
                                            $badgeClass = 'delivery-physical';
                                            if ($method === 'online') {
                                                $badgeClass = 'delivery-online';
                                            } elseif ($method === 'hybrid') {
                                                $badgeClass = 'delivery-hybrid';
                                            }
                                        @endphp
                                        <span class="delivery-badge {{ $badgeClass }}">
                                            {{ ucfirst($course->delivery_method) }}
                                        </span>
                                    </td>
                                    
                                    <!-- Pricing Column -->
                                    <td class="price-tag">
                                        ${{ number_format($course->base_price, 2) }}
                                    </td>
                                    
                                    <!-- Inline Actions -->
                                    <td style="text-align: center;">
                                        <a href="{{ route('admin.courses.show', $course->id) }}" class="btn-action-view">
                                            <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Details
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 32px; color: var(--text-muted); font-style: italic;">
                                        No courses registered in the system catalog yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div> <!-- End Container -->
        </main>
    </div>

    <!-- Sidebar Mobile Toggle JavaScript -->
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