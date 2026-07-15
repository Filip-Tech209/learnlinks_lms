<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\StudentService;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected StudentService $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $students = Student::query()
            ->when($search, function ($query, $search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('student_number', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15);

        return view('admin.students.index', compact('students', 'search'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive,suspended',
            'enrollment_date' => 'required|date',
            'details.date_of_birth' => 'nullable|date',
            'details.gender' => 'nullable|in:male,female,other,prefer_not_to_say',
            'details.address' => 'nullable|string',
            'details.national_id_or_passport' => 'nullable|string|max:100',
            'details.profile_image_path' => 'nullable|image|max:2048',
            'details.academic_background' => 'nullable|string',
            'emergency_contacts' => 'nullable|array',
            'emergency_contacts.*.id' => 'nullable',
            'emergency_contacts.*.name' => 'required_with:emergency_contacts|string|max:255',
            'emergency_contacts.*.relationship' => 'required_with:emergency_contacts|string|max:100',
            'emergency_contacts.*.phone' => 'required_with:emergency_contacts|string|max:50',
            'emergency_contacts.*.email' => 'nullable|email',
        ]);

        $this->studentService->store($validated);

        return redirect()->route('admin.students.index')->with('success', 'Student successfully enrolled!');
    }

    public function show(Student $student)
    {
        $student->load(['details', 'emergencyContacts']);
        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $student->load(['details', 'emergencyContacts']);
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'phone' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive,suspended',
            'enrollment_date' => 'required|date',
            'details.date_of_birth' => 'nullable|date',
            'details.gender' => 'nullable|in:male,female,other,prefer_not_to_say',
            'details.address' => 'nullable|string',
            'details.national_id_or_passport' => 'nullable|string|max:100',
            'details.profile_image_path' => 'nullable|image|max:2048',
            'details.academic_background' => 'nullable|string',
            'emergency_contacts' => 'nullable|array',
            'emergency_contacts.*.id' => 'nullable',
            'emergency_contacts.*.name' => 'required_with:emergency_contacts|string|max:255',
            'emergency_contacts.*.relationship' => 'required_with:emergency_contacts|string|max:100',
            'emergency_contacts.*.phone' => 'required_with:emergency_contacts|string|max:50',
            'emergency_contacts.*.email' => 'nullable|email',
        ]);

        $this->studentService->update($student, $validated);

        return redirect()->route('admin.students.show', $student->id)->with('success', 'Student details updated!');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Student record deleted permanently.');
    }
}