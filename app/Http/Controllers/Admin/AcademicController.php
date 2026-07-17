<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Course;
use App\Models\Enrollment;
use App\Services\EnrollmentService;
use Illuminate\Http\Request;

class AcademicController extends Controller
{
    protected EnrollmentService $enrollmentService;

    public function __construct(EnrollmentService $enrollmentService)
    {
        $this->enrollmentService = $enrollmentService;
    }

    // Show form to enroll a student in a course
    public function createEnrollment(Student $student)
    {
        // Prevent enrolling in courses already taken
        $enrolledIds = $student->enrollments()->pluck('course_id')->toArray();
        $courses = Course::whereNotIn('id', $enrolledIds)->get();

        return view('admin.students.enroll', compact('student', 'courses'));
    }

    // Save enrollment
    public function storeEnrollment(Request $request, Student $student)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'enrollment_date' => 'required|date'
        ]);

        $validated['student_id'] = $student->id;

        try {
            $this->enrollmentService->enrollStudent($validated);
            return redirect()->route('admin.students.show', $student->id)
                             ->with('success', 'Student enrolled in course successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Enrollment failed: ' . $e->getMessage()]);
        }
    }

    // Show progress checklists (module checkoffs)
    public function manageProgress(Enrollment $enrollment)
    {
        $enrollment->load(['student', 'course', 'progressLogs.module']);
        return view('admin.students.progress', compact('enrollment'));
    }

    // Process progress update
    public function updateProgress(Request $request, Enrollment $enrollment)
    {
        $completedModuleIds = $request->input('modules', []); // Array of checked module IDs
        
        $this->enrollmentService->updateProgress($enrollment, $completedModuleIds);

        return redirect()->route('admin.students.show', $enrollment->student_id)
                         ->with('success', 'Academic progress checklist updated!');
    }

    // Issue certificate
    public function issueCertificate(Request $request, Enrollment $enrollment)
    {
        $request->validate(['grade' => 'required|string|max:10']);

        try {
            $this->enrollmentService->issueCertificate($enrollment, $request->input('grade'));
            return redirect()->route('admin.students.show', $enrollment->student_id)
                             ->with('success', 'Certificate issued successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // Render Certificate PDF/Print View
    public function viewCertificate(Certificate $certificate)
    {
        $certificate->load(['enrollment.student', 'enrollment.course']);
        return view('admin.students.certificate', compact('certificate'));
    }
}