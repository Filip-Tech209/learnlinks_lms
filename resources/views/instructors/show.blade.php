@include('layouts.instructor_style')

<div class="container">
    <div class="header-section" style="margin-bottom: 2rem;">
        <div>
            <span style="font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">
                Instructor Profile Detail
            </span>
            <h1 style="margin-top: 0.25rem;">{{ $instructor->full_name }} ({{ $instructor->instructor_number }})</h1>
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <a href="{{ route('instructors.index') }}" class="btn btn-back">&larr; Back</a>
            <a href="{{ route('instructors.edit', $instructor->id) }}" class="btn btn-primary" style="background: #475569;">Edit Profile</a>
            
            <form action="{{ route('instructors.destroy', $instructor->id) }}" method="POST" onsubmit="return confirm('Delete this instructor permanent profile?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" style="background: var(--danger); color: white;">Delete</button>
            </form>
        </div>
    </div>

    <div class="grid-2">
        <!-- left column: card stats -->
        <div class="dynamic-card" style="margin-bottom: 0;">
            <h3 style="margin-top: 0;">Operational Info</h3>
            
            <div style="margin-bottom: 1rem;">
                <label style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 600;">Status</label>
                <div style="margin-top: 0.25rem;">
                    <span class="badge badge-{{ $instructor->status }}">{{ $instructor->status }}</span>
                </div>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 600;">Hire Date</label>
                <div style="font-size: 1rem; font-weight: 500; margin-top: 0.25rem;">{{ $instructor->hire_date }}</div>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 600;">Direct Specialty</label>
                <div style="font-size: 1rem; font-weight: 500; margin-top: 0.25rem; color: var(--primary);">{{ $instructor->detail->specialty ?? 'Generalist' }}</div>
            </div>

            <div style="margin-bottom: 0;">
                <label style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 600;">Gender</label>
                <div style="font-size: 1rem; font-weight: 500; margin-top: 0.25rem; text-transform: capitalize;">{{ $instructor->detail->gender ?? 'Not Specified' }}</div>
            </div>
        </div>

        <!-- right column: contact/meta -->
        <div class="dynamic-card" style="margin-bottom: 0;">
            <h3 style="margin-top: 0;">Identity & Contact Info</h3>

            <div style="margin-bottom: 1rem;">
                <label style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 600;">Email Address</label>
                <div style="font-size: 1rem; font-weight: 500; margin-top: 0.25rem;">{{ $instructor->email }}</div>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 600;">Phone Number</label>
                <div style="font-size: 1rem; font-weight: 500; margin-top: 0.25rem;">{{ $instructor->phone ?? 'No Phone Number Registered' }}</div>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 600;">Date of Birth</label>
                <div style="font-size: 1rem; font-weight: 500; margin-top: 0.25rem;">{{ $instructor->detail->date_of_birth ?? 'Not Provided' }}</div>
            </div>

            <div style="margin-bottom: 0;">
                <label style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 600;">Physical Address</label>
                <div style="font-size: 0.95rem; line-height: 1.4; margin-top: 0.25rem;">{{ $instructor->detail->address ?? 'Not Provided' }}</div>
            </div>
        </div>
    </div>

    <div class="dynamic-card" style="margin-top: 1.5rem; margin-bottom: 1.5rem;">
        <h3 style="margin-top: 0;">Biography</h3>
        <p style="font-size: 0.95rem; line-height: 1.6; color: #334155; margin: 0;">
            {{ $instructor->detail->bio ?? 'This instructor profile has no detailed biography.' }}
        </p>
    </div>

    <div class="dynamic-card" style="margin-bottom: 0;">
        <h3 style="margin-top: 0;">Credentials & Professional Certifications</h3>
        
        @if($instructor->certifications->isNotEmpty())
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem; margin-top: 1rem;">
                @foreach($instructor->certifications as $cert)
                    <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: 6px; padding: 1rem;">
                        <div style="font-weight: 600; font-size: 0.95rem; color: #0f172a;">{{ $cert->name }}</div>
                        <div style="font-size: 0.85rem; color: #64748b; margin-top: 0.25rem;">Issued by: <strong style="color: #475569;">{{ $cert->issuing_authority }}</strong></div>
                        <div style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.5rem;">Attained: {{ $cert->attained_date }}</div>
                    </div>
                @endforeach
            </div>
        @else
            <p style="color: #64748b; font-size: 0.95rem; margin: 0; padding: 1rem 0;">No professional certifications registered under this profile.</p>
        @endif
    </div>
</div>