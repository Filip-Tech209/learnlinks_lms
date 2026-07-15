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
                <p><strong>Enrolled:</strong> {{ $student->enrollment_date->format('M d, Y') }}</p>
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
        </div>
    </div>

</body>
</html>