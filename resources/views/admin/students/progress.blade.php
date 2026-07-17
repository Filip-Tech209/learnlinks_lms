<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Track Course Progress</title>
</head>
<body style="font-family: system-ui, sans-serif; padding: 20px; max-width: 700px; margin: 0 auto; color: #333; background: #f8fafc;">

    <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
        <h2 style="margin-top: 0; color: #0f172a;">Manage Module Checklists</h2>
        <p style="color: #64748b; line-height: 1.5; margin-bottom: 25px;">
            Student: <strong>{{ $enrollment->student->full_name }}</strong><br>
            Course: <strong style="color: #2563eb;">{{ $enrollment->course->title }}</strong>
        </p>
        <hr style="border: none; border-top: 1px solid #e2e8f0; margin-bottom: 20px;">

        <form action="{{ route('admin.enrollments.progress.update', $enrollment->id) }}" method="POST">
            @csrf

            <h3 style="color: #475569; font-size: 1.1em; margin-bottom: 15px;">Check completed modules below:</h3>

            <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 30px;">
                @forelse($enrollment->progressLogs as $log)
                    <label style="display: flex; align-items: flex-start; gap: 12px; background: #f8fafc; border: 1px solid #e2e8f0; padding: 12px; border-radius: 6px; cursor: pointer; transition: background 0.15s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">
                        <input type="checkbox" name="modules[]" value="{{ $log->module_id }}" {{ $log->is_completed ? 'checked' : '' }} style="margin-top: 4px; transform: scale(1.2); cursor: pointer;">
                        <div>
                            <strong style="color: #1e293b; display: block;">{{ $log->module->title ?? 'Untitled Module' }}</strong>
                            <span style="font-size: 0.85em; color: #64748b;">
                                @if($log->is_completed && $log->completed_at)
                                    Completed on {{ $log->completed_at->format('M d, Y - h:i A') }}
                                @else
                                    Status: Pending
                                @endif
                            </span>
                        </div>
                    </label>
                @empty
                    <p style="color: #64748b; font-style: italic;">No course modules initialized for this course.</p>
                @endforelse
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <a href="{{ route('admin.students.show', $enrollment->student_id) }}" style="text-decoration: none;">
                    <button type="button" style="padding: 10px 20px; background: white; border: 1px solid #cbd5e1; color: #475569; border-radius: 6px; cursor: pointer;">Cancel</button>
                </a>
                <button type="submit" style="padding: 10px 20px; background: #16a34a; border: none; color: white; font-weight: bold; border-radius: 6px; cursor: pointer;">Update Progress</button>
            </div>
        </form>
    </div>

</body>
</html>