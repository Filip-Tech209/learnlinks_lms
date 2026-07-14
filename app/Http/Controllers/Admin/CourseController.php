<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Course, CourseCategory};
use App\Services\CourseService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected $service;

    public function __construct(CourseService $service) {
        $this->service = $service;
    }

    public function index() {
        $courses = Course::latest()->get();
        return view('admin.courses.index', compact('courses'));
    }

    public function create() {
        $categories = CourseCategory::all();
        return view('admin.courses.create', compact('categories'));
    }

    public function store(Request $request) {
        $rules = [
            'faqs' => 'nullable|array',
            'faqs.*.id' => 'nullable',
            'faqs.*.question' => 'required_with:faqs|string',
            'faqs.*.answer' => 'required_with:faqs|string',
        ];
        $data = $request->all();

        // Handle File Upload if present
        if ($request->hasFile('brochure')) {
            $path = $request->file('brochure')->store('brochures', 'public');
            $data['meta']['brochure_path'] = $path; // Inject the path into our meta array
        }
         // Handle image upload for featured image if present
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('featured_images', 'public');
            $data['meta']['featured_image_path'] = $path; // Inject the path into our meta array
        }

        $this->service->store($data);
        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully!');
    }

    public function show(Course $course) {
        $course->load(['category', 'meta', 'modules', 'schedules', 'faqs']);
        return view('admin.courses.show', compact('course'));
    }

    public function edit(Course $course) {
        $course->load(['meta', 'modules', 'schedules', 'faqs']);
        $categories = CourseCategory::all();
        return view('admin.courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, Course $course) {
        $rules = [
            'faqs' => 'nullable|array',
            'faqs.*.id' => 'nullable',
            'faqs.*.question' => 'required_with:faqs|string',
            'faqs.*.answer' => 'required_with:faqs|string',
        ];
        $this->service->update($course, $request->all());
        return redirect()->route('admin.courses.show', $course->id)->with('success', 'Course updated successfully!');
    }

    public function destroy(Course $course) {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Course deleted.');
    }
}