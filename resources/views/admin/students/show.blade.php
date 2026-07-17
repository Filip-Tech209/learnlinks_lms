<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Profile: {{ $student->full_name }}</title>
</head>
<body style="font-family: system-ui, sans-serif; padding: 20px; max-width: 1000px; margin: 0 auto; color: #333;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <a href="{{ route('admin.students.index') }}"><button style="padding: 6px 12px;">&larr; Back to Directory</button></a>
        <div>
            <a href="{{ route('admin.students.edit', $student->id) }}">
                <button style="padding: 6px 15px; background: #ffc107; border: 1px solid #cc9a06; cursor: pointer; border-radius: 4px; font-weight: bold;">Edit Profile</button>
            </a>
        </div>
    </div>
    <hr>

    @if(session('success')) 
        <p style="color: green; font-weight: bold; padding: 10px; background: #e6f4ea; border-radius: 4px;">{{ session('success') }}</p> 
    @endif

    <div style="display: flex; gap: 20px; margin-top: 20px;">
        {{-- Profile Core Sidebar --}}
        <div style="flex: 1; background: #fafafa; border: 1px solid #dee2e6; padding: 20px; border-radius: 6px; height: fit-content;">
            <div style="width: 100px; height: 100px; background: #e2e8f0; border-radius: 50%; margin: 0 auto 15px auto; display: flex; align-items: center; justify-content: center; font-size: 2.5em; color: #718096; font-weight: bold;">
                {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
            </div>
            <h2 style="text-align: center; margin: 0 0 5px 0;">{{ $student->full_name }}</h2>
            <p style="text-align: center; color: #718096; margin: 0 0 15px 0; font-weight: bold;">{{ $student->student_number }}</p>

            <div style="border-top: 1px solid #e2e8f0; padding-top: 15px; font-size: 0.95em;">
                <p><strong>Status:</strong> 
                    <span style="text-transform: capitalize; font-weight: bold; color: {{ $student->status === 'active' ? 'green' : 'red' }}">{{ $student->status }}</span>
                </p>
                <p><strong>Email:</strong> <span style="word-break: break-all;">{{ $student->email }}</span></p>
                <p><strong>Phone:</strong> {{ $student->phone ?? 'Not Provided' }}</p>
                <p><strong>Admitted:</strong> {{ $student->admission_date->format('M d, Y') }}</p>
            </div>
        </div>

        {{-- Expanded Profile Details --}}
        <div style="flex: 2; display: flex; flex-direction: column; gap: 20px;">
            <div style="border: 1px solid #dee2e6; padding: 20px; border-radius: 6px; background: white;">
                <h3 style="margin-top: 0; border-bottom: 2px solid #f1f5f9; padding-bottom: 8px;">Personal Information</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <small style="color: #718096; display: block;">Date of Birth</small>
                        <strong>{{ $student->details->date_of_birth ? $student->details->date_of_birth->format('F d, Y') : 'Not Provided' }}</strong>
                    </div>
                    <div>
                        <small style="color: #718096; display: block;">Gender</small>
                        <strong style="text-transform: capitalize;">{{ str_replace('_', ' ', $student->details->gender ?? 'Not Provided') }}</strong>
                    </div>
                    <div>
                        <small style="color: #718096; display: block;">National ID / Passport</small>
                        <strong>{{ $student->details->national_id_or_passport ?? 'Not Provided' }}</strong>
                    </div>
                    <div style="grid-column: span 2;">
                        <small style="color: #718096; display: block;">Home Address</small>
                        <strong>{{ $student->details->address ?? 'Not Provided' }}</strong>
                    </div>
                </div>
            </div>

            <div style="border: 1px solid #dee2e6; padding: 20px; border-radius: 6px; background: white;">
                <h3 style="margin-top: 0; border-bottom: 2px solid #f1f5f9; padding-bottom: 8px;">Academic Credentials</h3>
                <p style="white-space: pre-line; line-height: 1.5; color: #4a5568;">{{ $student->details->academic_background ?? 'No academic credentials registered yet.' }}</p>
            </div>

            <div style="border: 1px solid #dee2e6; padding: 20px; border-radius: 6px; background: white;">
                <h3 style="margin-top: 0; border-bottom: 2px solid #f1f5f9; padding-bottom: 8px;">Emergency Contacts</h3>
                @if($student->emergencyContacts->isNotEmpty())
                    <table style="width: 100%; border-collapse: collapse; font-size: 0.95em;">
                        <thead>
                            <tr style="text-align: left; border-bottom: 1px solid #e2e8f0; color: #718096;">
                                <th style="padding: 8px 0;">Name</th>
                                <th style="padding: 8px 0;">Relationship</th>
                                <th style="padding: 8px 0;">Phone Number</th>
                                <th style="padding: 8px 0;">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($student->emergencyContacts as $contact)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 10px 0; font-weight: bold;">{{ $contact->name }}</td>
                                    <td style="padding: 10px 0;">{{ $contact->relationship }}</td>
                                    <td style="padding: 10px 0;">{{ $contact->phone }}</td>
                                    <td style="padding: 10px 0; color: #718096;">{{ $contact->email ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p style="color: #718096; font-style: italic; margin: 10px 0 0 0;">No emergency contacts configured.</p>
                @endif
            </div>

            <!-- Course Enrollment & Progress Panel -->
            <div style="border: 1px solid #dee2e6; padding: 20px; border-radius: 6px; background: white; margin-top: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; margin-bottom: 15px;">
                    <h3 style="margin: 0; font-size: 1.15rem; color: #1e293b;">Active Enrollments & Progress</h3>
                    <a href="{{ route('admin.students.enroll', $student->id) }}" style="text-decoration: none;">
                        <button style="padding: 6px 12px; background: #2563eb; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 0.85em;">
                            + Enroll in Course
                        </button>
                    </a>
                </div>

                @if($student->enrollments->isNotEmpty())
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        @foreach($student->enrollments as $enrollment)
                            <div style="border: 1px solid #e2e8f0; border-radius: 6px; padding: 15px; background: #f8fafc;">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                    <div>
                                        <strong style="font-size: 1.1em; color: #0f172a;">{{ $enrollment->course->title }}</strong>
                                        <div style="font-size: 0.85em; color: #64748b; margin-top: 3px;">
                                            Enrolled On: 
                                        </div>
                                    </div>
                                    <span style="background: {{ $enrollment->status === 'completed' ? '#d1e7dd' : '#eff6ff' }}; color: {{ $enrollment->status === 'completed' ? '#0f5132' : '#1e40af' }}; padding: 4px 10px; border-radius: 50px; font-size: 0.8em; font-weight: bold; text-transform: uppercase;">
                                        {{ $enrollment->status }}
                                    </span>
                                </div>

                                <!-- Progress Bar -->
                                <div style="margin-top: 15px;">
                                    <div style="display: flex; justify-content: space-between; font-size: 0.85em; margin-bottom: 5px;">
                                        <span style="color: #475569; font-weight: 500;">Learning Track Completion</span>
                                        <span style="font-weight: bold; color: #0f172a;">{{ $enrollment->progress_percent }}%</span>
                                    </div>
                                    <div style="width: 100%; height: 8px; background: #e2e8f0; border-radius: 10px; overflow: hidden;">
                                        <div style="width: {{ $enrollment->progress_percent }}%; height: 100%; background: #16a34a; border-radius: 10px; transition: width 0.3s ease;"></div>
                                    </div>
                                </div>

                                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 15px; border-top: 1px solid #e2e8f0; padding-top: 12px;">
                                    <a href="{{ route('admin.enrollments.progress', $enrollment->id) }}">
                                        <button style="padding: 5px 12px; background: white; border: 1px solid #cbd5e1; color: #475569; border-radius: 4px; cursor: pointer; font-size: 0.85em;">
                                            Track Modules
                                        </button>
                                    </a>

                                    <!-- Certificate Action Trigger -->
                                    @if($enrollment->progress_percent === 100)
                                        @if($enrollment->certificate)
                                            <a href="{{ route('admin.certificates.view', $enrollment->certificate->id) }}" target="_blank">
                                                <button style="padding: 5px 12px; background: #16a34a; border: none; color: white; border-radius: 4px; cursor: pointer; font-size: 0.85em; font-weight: bold;">
                                                    View Certificate
                                                </button>
                                            </a>
                                        @else
                                            <form action="{{ route('admin.enrollments.certificate.issue', $enrollment->id) }}" method="POST" style="display: inline-flex; gap: 5px; align-items: center;">
                                                @csrf
                                                <select name="grade" required style="padding: 4px; border-radius: 4px; border: 1px solid #cbd5e1; font-size: 0.85em;">
                                                    <option value="Distinction">Distinction</option>
                                                    <option value="Merit">Merit</option>
                                                    <option value="Pass" selected>Pass</option>
                                                </select>
                                                <button type="submit" style="padding: 5px 12px; background: #2563eb; border: none; color: white; border-radius: 4px; cursor: pointer; font-size: 0.85em; font-weight: bold;">
                                                    Issue Certificate
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="color: #64748b; font-style: italic; margin: 0; padding: 10px 0;">No active course tracks have been set for this student.</p>
                @endif
            </div>

        </div>
    </div>

</body>
</html>