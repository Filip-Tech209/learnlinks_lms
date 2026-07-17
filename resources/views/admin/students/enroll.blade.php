<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Course Enrollment</title>
</head>
<body style="font-family: system-ui, sans-serif; padding: 20px; max-width: 600px; margin: 0 auto; color: #333; background: #f8fafc;">

    <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
        <h2 style="margin-top: 0; color: #0f172a;">Enroll in a Course</h2>
        <p style="color: #64748b; margin-bottom: 25px;">Enrolling Student: <strong>{{ $student->full_name }} ({{ $student->student_number }})</strong></p>
        <hr style="border: none; border-top: 1px solid #e2e8f0; margin-bottom: 20px;">

        @if($errors->any())
            <p style="color: red; padding: 10px; background: #fff5f5; border-radius: 4px; border: 1px solid #fecaca; font-size: 0.9em;">
                {{ $errors->first() }}
            </p>
        @endif

        <form action="{{ route('admin.students.enroll.store', $student->id) }}" method="POST">
            @csrf

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #475569;">Select Available Course:</label>
                <select name="course_id" required style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #cbd5e1; background: white; font-size: 0.95em;">
                    <option value="">-- Choose Course --</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->title }} ({{ $course->duration }})</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #475569;">Enrollment Effective Date:</label>
                <input type="date" name="enrollment_date" value="{{ date('Y-m-d') }}" required style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #cbd5e1; box-sizing: border-box; font-size: 0.95em;">
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <a href="{{ route('admin.students.show', $student->id) }}" style="text-decoration: none;">
                    <button type="button" style="padding: 10px 20px; background: white; border: 1px solid #cbd5e1; color: #475569; border-radius: 6px; cursor: pointer;">Cancel</button>
                </a>
                <button type="submit" style="padding: 10px 20px; background: #2563eb; border: none; color: white; font-weight: bold; border-radius: 6px; cursor: pointer;">Complete Enrollment</button>
            </div>
        </form>
    </div>

</body>
</html>