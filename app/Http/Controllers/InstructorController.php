<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Services\InstructorService;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    protected InstructorService $instructorService;

    public function __construct(InstructorService $instructorService)
    {
        $this->instructorService = $instructorService;
    }

    public function index()
    {
        $instructors = Instructor::with(['detail'])->orderBy('last_name')->paginate(15);
        return view('instructors.index', compact('instructors'));
    }

    public function create()
    {
        return view('instructors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'instructor.first_name' => 'required|string|max:255',
            'instructor.last_name' => 'required|string|max:255',
            'instructor.email' => 'required|email|unique:instructors,email',
            'instructor.phone' => 'nullable|string|max:50',
            'instructor.status' => 'required|string|in:active,inactive,suspended',
            'instructor.hire_date' => 'required|date',
            'detail.date_of_birth' => 'nullable|date',
            'detail.gender' => 'nullable|string',
            'detail.address' => 'nullable|string',
            'detail.qualifications' => 'nullable|string',
            'detail.profile_image_path' => 'nullable|string|1024|max:2048', 
            'detail.specialty' => 'nullable|string|max:255',
            'certifications.*.name' => 'nullable|required_with:certifications.*.issuing_authority|string|max:255',
            'certifications.*.issuing_authority' => 'nullable|required_with:certifications.*.name|string|max:255',
            'certifications.*.attained_date' => 'nullable|required_with:certifications.*.name|date',
        ]);

       // Generate dynamic sequential instructor number for the current year
        $year = now()->year;

        $lastInstructor = Instructor::where('instructor_number', 'like', "INS/%/$year")
            ->orderByDesc('id')
            ->first();

        if ($lastInstructor && preg_match('/INS\/(\d+)\/\d{4}/', $lastInstructor->instructor_number, $matches)) {
            $nextNumber = (int) $matches[1] + 1;
        } else {
            $nextNumber = 1;
        }

        $validated['instructor']['instructor_number'] = sprintf(
            'INS/%03d/%d',
            $nextNumber,
            $year
        );

        $this->instructorService->store($validated);

        return redirect()->route('instructors.index')->with('success', 'Instructor profile created successfully!');
    }

    public function show(Instructor $instructor)
    {
        $instructor->load(['detail', 'certifications']);
        return view('instructors.show', compact('instructor'));
    }

    public function edit(Instructor $instructor)
    {
        $instructor->load(['detail', 'certifications']);
        return view('instructors.edit', compact('instructor'));
    }

    public function update(Request $request, Instructor $instructor)
    {
        $validated = $request->validate([
            'instructor.first_name' => 'required|string|max:255',
            'instructor.last_name' => 'required|string|max:255',
            'instructor.email' => 'required|email|unique:instructors,email,' . $instructor->id,
            'instructor.phone' => 'nullable|string|max:50',
            'instructor.status' => 'required|string|in:active,inactive,suspended',
            'instructor.hire_date' => 'required|date',
            'detail.date_of_birth' => 'nullable|date',
            'detail.gender' => 'nullable|string',
            'detail.address' => 'nullable|string',
            'detail.bio' => 'nullable|string',
            'detail.specialty' => 'nullable|string|max:255',
            'certifications.*.id' => 'nullable',
            'certifications.*.name' => 'nullable|required_with:certifications.*.issuing_authority|string|max:255',
            'certifications.*.issuing_authority' => 'nullable|required_with:certifications.*.name|string|max:255',
            'certifications.*.attained_date' => 'nullable|required_with:certifications.*.name|date',
        ]);

        $this->instructorService->update($instructor, $validated);

        return redirect()->route('instructors.index')->with('success', 'Instructor profile updated successfully!');
    }

    public function destroy(Instructor $instructor)
    {
        $this->instructorService->delete($instructor);
        return redirect()->route('instructors.index')->with('success', 'Instructor profile removed from active directory.');
    }
}