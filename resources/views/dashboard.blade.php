<h1>Dashboard</h1>
<p>Welcome, {{ auth()->user()->name ?? 'Admin' }}</p>

@if(session('success')) 
    <p style="color: green;">{{ session('success') }}</p> 
@elseif ($errors->any()) 
    <p style="color: red;">{{ $errors->first() }}</p> 
@endif  

<form method="POST" action="{{ route('logout') }}" style="display:inline;">
    @csrf
    <button type="submit">Logout</button>
</form>

<hr>

<h2>Manage Courses</h2>
<a href="{{ route('admin.courses.create') }}"><button>Add New Course</button></a>
<a href="{{ route('admin.courses.index') }}"><button>View All Courses</button></a>

<h2>Manage Students</h2>
<a href="{{ route('admin.students.create') }}"><button>Add New Student</button></a>
<a href="{{ route('admin.students.index') }}"><button>View All Students</button></a>

<!-- Added Instructor Management Section -->
<h2>Manage Instructors</h2>
<a href="{{ route('instructors.index') }}"><button>View All Instructors</button></a>