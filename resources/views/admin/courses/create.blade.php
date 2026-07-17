<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Course - LearnLink Institute</title>
    
    <!-- Unified Layout styles and dedicated compact form overrides -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/course_create.css') }}">
    
    <!-- Alpine.js Deferred Library -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                <a href="{{ route('dashboard') }}" class="nav-item">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Home / Dashboard
                </a>
                
                <a href="{{ route('admin.courses.index') }}" class="nav-item active">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    Manage Courses
                </a>
                
                <a href="{{ route('admin.students.index') }}" class="nav-item">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Manage Students
                </a>
                
                <a href="{{ route('instructors.index') }}" class="nav-item">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Manage Instructors
                </a>
            </nav>
            
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

            <div class="content-container" style="padding: 16px; gap: 12px;">

                <!-- Notification Panel -->
                @if(session('success')) 
                    <div class="alert alert-success" style="padding: 6px 12px; font-size: 11.5px; margin-bottom: 4px;">
                        <svg style="width:14px; height:14px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                @elseif ($errors->any()) 
                    <div class="alert alert-danger" style="padding: 6px 12px; font-size: 11.5px; margin-bottom: 4px;">
                        <svg style="width:14px; height:14px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $errors->first() }}
                    </div>
                @endif  

                <div class="back-btn-row">
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline" style="padding: 4px 8px; font-size: 10.5px; font-weight: 700;">
                        &larr; Back to Catalog
                    </a>
                </div>

                <div class="form-header-group">
                    <h2>Register New Course</h2>
                    <p>Enter details below. Layout configured as a dense single-page structure.</p>
                </div>

                <form action="{{ route('admin.courses.store') }}" 
                      method="POST" 
                      enctype="multipart/form-data" 
                      x-data="courseForm()">
                    @csrf

                    <!-- 1. Core Details -->
                    <section class="form-section">
                        <div class="form-section-header">
                            <div class="section-title-left">
                                <span class="section-number">1</span>
                                <h3>Core Academic Details</h3>
                            </div>
                        </div>
                        
                        <div class="form-grid-4">
                            <div class="form-group span-2">
                                <label for="title">Course Title</label>
                                <input type="text" name="title" id="title" class="input-control" placeholder="e.g. Software Engineering" required>
                            </div>

                            <div class="form-group span-2">
                                <label for="category_id">Category</label>
                                <select name="category_id" id="category_id" class="input-control" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $cat) 
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option> 
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group span-4">
                                <label for="description">Overview Description</label>
                                <textarea name="description" id="description" class="input-control" placeholder="Write a compact description summary..."></textarea>
                            </div>

                            <div class="form-group">
                                <label for="delivery_method">Delivery Mode</label>
                                <input type="text" name="delivery_method" id="delivery_method" class="input-control" placeholder="Hybrid, Online, etc" required>
                            </div>

                            <div class="form-group">
                                <label for="duration">Duration</label>
                                <input type="text" name="duration" id="duration" class="input-control" placeholder="e.g. 5 Days" required>
                            </div>

                            <div class="form-group">
                                <label for="base_price">Base Price ($)</label>
                                <input type="number" name="base_price" id="base_price" class="input-control" placeholder="e.g. 1200" step="0.01">
                            </div>

                            <div class="form-group">
                                <label for="featured_image">Featured Thumbnail</label>
                                <input type="file" name="featured_image" id="featured_image" class="input-control" style="padding: 3px 6px;">
                            </div>
                        </div>
                    </section>

                    <!-- 2. Meta Data -->
                    <section class="form-section">
                        <div class="form-section-header">
                            <div class="section-title-left">
                                <span class="section-number">2</span>
                                <h3>Program Outcomes & Requirements</h3>
                            </div>
                        </div>
                        
                        <div class="form-grid-3">
                            <div class="form-group">
                                <label for="language">Instruction Language</label>
                                <input type="text" name="meta[language]" id="language" class="input-control" value="English">
                            </div>

                            <div class="form-group span-2">
                                <label for="brochure">Brochure PDF</label>
                                <input type="file" name="brochure" id="brochure" accept=".pdf" class="input-control" style="padding: 3px 6px;">
                            </div>

                            <div class="form-group">
                                <label for="objectives">Objectives</label>
                                <textarea name="meta[objectives]" id="objectives" class="input-control" placeholder="Course goals..."></textarea>
                            </div>

                            <div class="form-group">
                                <label for="organizational_impacts">Organizational Impacts</label>
                                <textarea name="meta[organizational_impacts]" id="organizational_impacts" class="input-control" placeholder="Corporate benefits..."></textarea>
                            </div>

                            <div class="form-group">
                                <label for="personal_impacts">Personal Impacts</label>
                                <textarea name="meta[personal_impacts]" id="personal_impacts" class="input-control" placeholder="Career benefit..."></textarea>
                            </div>

                            <div class="form-group">
                                <label for="certification_details">Certification</label>
                                <textarea name="meta[certification_details]" id="certification_details" class="input-control" placeholder="Provided credentials..."></textarea>
                            </div>

                            <div class="form-group">
                                <label for="training_methodology">Methodology</label>
                                <textarea name="meta[training_methodology]" id="training_methodology" class="input-control" placeholder="Practical methodology..."></textarea>
                            </div>

                            <div class="form-group">
                                <label for="requirements">Prerequisites</label>
                                <textarea name="meta[requirements]" id="requirements" class="input-control" placeholder="Required qualifications..."></textarea>
                            </div>
                        </div>
                    </section>

                    <!-- 3. Dense Modules (Horizontal Layout) -->
                    <section class="form-section">
                        <div class="form-section-header">
                            <div class="section-title-left">
                                <span class="section-number">3</span>
                                <h3>Syllabus Module Breakdown</h3>
                            </div>
                            <button type="button" class="btn-add-compact" @click="modules.push({ title: '', content: '' })">
                                + Add Module
                            </button>
                        </div>
                        
                        <div class="dynamic-row-container">
                            <!-- Headers only shown on non-mobile devices -->
                            <div class="dynamic-row-header">
                                <div style="text-align: center;">Seq.</div>
                                <div>Module Title</div>
                                <div>Syllabus / Topics Covered</div>
                                <div style="text-align: center;">Actions</div>
                            </div>

                            <template x-for="(module, index) in modules" :key="index">
                                <div class="dynamic-item-row">
                                    <div class="row-index" x-text="index + 1"></div>
                                    
                                    <div class="form-group">
                                        <input type="text" 
                                               :name="`modules[${index}][title]`" 
                                               x-model="module.title" 
                                               class="input-control" 
                                               placeholder="Module Title" 
                                               required>
                                    </div>
                                    
                                    <input type="hidden" :name="`modules[${index}][order]`" :value="index + 1">

                                    <div class="form-group">
                                        <input type="text" 
                                               :name="`modules[${index}][content]`" 
                                               class="input-control" 
                                               placeholder="Enter core module topics, notes..."
                                               x-model="module.content">
                                    </div>

                                    <div>
                                        <button type="button" class="btn-remove-compact" @click="modules.splice(index, 1)">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </section>

                    <!-- 4. Dense Schedules (Horizontal Layout) -->
                    <section class="form-section">
                        <div class="form-section-header">
                            <div class="section-title-left">
                                <span class="section-number">4</span>
                                <h3>Timetables & Schedules</h3>
                            </div>
                            <button type="button" class="btn-add-compact" @click="schedules.push({ delivery_mode: 'online', start_date: '', end_date: '', cost: '' })">
                                + Add Schedule
                            </button>
                        </div>
                        
                        <div class="dynamic-row-container">
                            <div class="dynamic-row-header schedule-header">
                                <div>Format</div>
                                <div>Start Date</div>
                                <div>End Date</div>
                                <div>Price Override ($)</div>
                                <div style="text-align: center;">Actions</div>
                            </div>

                            <template x-for="(schedule, index) in schedules" :key="index">
                                <div class="dynamic-item-row schedule-row">
                                    <div class="form-group">
                                        <select :name="`schedules[${index}][delivery_mode]`" class="input-control">
                                            <option value="online">Online</option>
                                            <option value="classroom">Classroom</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <input type="date" :name="`schedules[${index}][start_date]`" class="input-control">
                                    </div>

                                    <div class="form-group">
                                        <input type="date" :name="`schedules[${index}][end_date]`" class="input-control">
                                    </div>

                                    <div class="form-group">
                                        <input type="number" :name="`schedules[${index}][cost]`" class="input-control" placeholder="Base Cost">
                                    </div>

                                    <div>
                                        <button type="button" class="btn-remove-compact" @click="schedules.splice(index, 1)">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </section>

                    <div class="form-submit-row">
                        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline" style="padding: 6px 12px; font-size: 11px;">Cancel</a>
                        <button type="submit" class="btn btn-success" style="padding: 6px 16px; font-weight: 700; font-size: 11px;">
                            Save Entire Course Catalog
                        </button>
                    </div>

                </form>

            </div>
        </main>
    </div>

    <!-- Toggle Controller & Alpine initializers -->
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

        function courseForm() {
            return {
                modules: [{ title: '', content: '' }], 
                schedules: [{ delivery_mode: 'online', start_date: '', end_date: '', cost: '' }]
            }
        }
    </script>
</body>
</html>