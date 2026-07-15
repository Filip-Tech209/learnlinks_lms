@include('layouts.instructor_style')

<div class="container">
    <div class="header-section">
        <h1>Instructors Registry</h1>
        <a href="{{ route('instructors.create') }}" class="btn btn-primary">+ Add New Instructor</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Ref ID</th>
                    <th>Full Name</th>
                    <th>Specialty</th>
                    <th>Email Address</th>
                    <th>Hire Date</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($instructors as $instructor)
                    <tr>
                        <td style="font-weight: 600;">{{ $instructor->instructor_number }}</td>
                        <td>{{ $instructor->full_name }}</td>
                        <td>{{ $instructor->detail->specialty ?? 'N/A' }}</td>
                        <td>{{ $instructor->email }}</td>
                        <td>{{ $instructor->hire_date }}</td>
                        <td>
                            <span class="badge badge-{{ $instructor->status }}">
                                {{ $instructor->status }}
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <a href="{{ route('instructors.show', $instructor->id) }}" class="btn btn-back" style="padding: 0.35rem 0.75rem; font-size: 0.8rem;">View</a>
                            <a href="{{ route('instructors.edit', $instructor->id) }}" class="btn btn-primary" style="padding: 0.35rem 0.75rem; font-size: 0.8rem; background: #64748b;">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #64748b; padding: 2rem;">No registered instructors found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $instructors->links() }}
    </div>
</div>