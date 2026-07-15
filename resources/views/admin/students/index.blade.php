<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Directory</title>
</head>
<body style="font-family: system-ui, sans-serif; padding: 20px; max-width: 1200px; margin: 0 auto; color: #333;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Student Directory</h1>
        <a href="{{ route('admin.students.create') }}">
            <button style="padding: 10px 20px; background: #0d6efd; color: white; border: none; cursor: pointer; border-radius: 4px; font-weight: bold;">
                + Enroll New Student
            </button>
        </a>
    </div>
    <hr>

    @if(session('success')) 
        <p style="color: green; font-weight: bold; padding: 10px; background: #e6f4ea; border-radius: 4px;">{{ session('success') }}</p> 
    @endif

    {{-- Filter/Search Box --}}
    <form method="GET" action="{{ route('admin.students.index') }}" style="margin-bottom: 20px; display: flex; gap: 10px;">
        <input type="text" name="search" value="{{ $search }}" placeholder="Search by name, ID or email..." style="padding: 8px 12px; width: 300px; border: 1px solid #ccc; border-radius: 4px;">
        <button type="submit" style="padding: 8px 15px; background: #6c757d; color: white; border: none; cursor: pointer; border-radius: 4px;">Search</button>
        @if($search)
            <a href="{{ route('admin.students.index') }}" style="padding: 8px 15px; background: #e2e8f0; color: #333; text-decoration: none; border-radius: 4px; display: inline-flex; align-items: center;">Clear</a>
        @endif
    </form>

    <table style="width: 100%; border-collapse: collapse; margin-top: 10px; background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <thead>
            <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6; text-align: left;">
                <th style="padding: 12px;">Student ID</th>
                <th style="padding: 12px;">Full Name</th>
                <th style="padding: 12px;">Email Address</th>
                <th style="padding: 12px;">Enrollment Date</th>
                <th style="padding: 12px;">Status</th>
                <th style="padding: 12px; text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                <tr style="border-bottom: 1px solid #dee2e6; transition: background 0.1s;" onmouseover="this.style.background='#fcfcfc'" onmouseout="this.style.background='white'">
                    <td style="padding: 12px; font-weight: bold; color: #4a5568;">{{ $student->student_number }}</td>
                    <td style="padding: 12px;">{{ $student->full_name }}</td>
                    <td style="padding: 12px;">{{ $student->email }}</td>
                    <td style="padding: 12px;">{{ $student->enrollment_date->format('M d, Y') }}</td>
                    <td style="padding: 12px;">
                        @if($student->status === 'active')
                            <span style="background: #d1e7dd; color: #0f5132; padding: 4px 8px; border-radius: 12px; font-size: 0.85em; font-weight: bold;">Active</span>
                        @elseif($student->status === 'inactive')
                            <span style="background: #f8d7da; color: #842029; padding: 4px 8px; border-radius: 12px; font-size: 0.85em; font-weight: bold;">Inactive</span>
                        @else
                            <span style="background: #fff3cd; color: #664d03; padding: 4px 8px; border-radius: 12px; font-size: 0.85em; font-weight: bold;">Suspended</span>
                        @endif
                    </td>
                    <td style="padding: 12px; text-align: right; display: flex; gap: 5px; justify-content: flex-end;">
                        <a href="{{ route('admin.students.show', $student->id) }}">
                            <button style="padding: 4px 8px; border: 1px solid #0d6efd; color: #0d6efd; background: white; cursor: pointer; border-radius: 4px;">View</button>
                        </a>
                        <a href="{{ route('admin.students.edit', $student->id) }}">
                            <button style="padding: 4px 8px; border: 1px solid #ffc107; color: #856404; background: white; cursor: pointer; border-radius: 4px;">Edit</button>
                        </a>
                        <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Delete this record permanently?');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="padding: 4px 8px; border: 1px solid #dc3545; color: #dc3545; background: white; cursor: pointer; border-radius: 4px;">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="padding: 20px; text-align: center; color: #718096; font-style: italic;">No student records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $students->links() }}
    </div>

</body>
</html>