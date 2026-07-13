<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Course, CourseCategory, CourseMeta, CourseModule, CourseSchedule, CourseFaq};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CourseManagementSeeder extends Seeder
{
    public function run()
    {
        DB::transaction(function () {
            // 1. Create Category
            $category = CourseCategory::create([
                'name' => 'Data Collection & Analytics',
                'slug' => Str::slug('Data Collection & Analytics')
            ]);

            // 2. Create Course
            $course = Course::create([
                'category_id' => $category->id,
                'title' => 'Mobile Data Collection with ODK',
                'description' => 'A comprehensive course on modern data collection techniques.',
                'base_price' => 500.00,
                'delivery_method' => 'hybrid',
                'duration' => '5 Days',
                'is_active' => true,
                'slug' => Str::slug('Mobile Data Collection with ODK')
            ]);

            // 3. Create Meta
            $course->meta()->create([
                'objectives' => 'Learn ODK, server configuration, and data visualization.',
                'organizational_impacts' => 'Improved data accuracy and real-time reporting.',
                'personal_impacts' => 'Enhanced digital skills and career growth.',
                'brochure_path' => 'brochures/odk-course.pdf',
                'certification_details' => 'Professional Certificate of Completion issued.',
                'language' => 'English',
                'requirements' => 'Laptop with at least 8GB RAM.'
            ]);

            // 4. Create Modules
            $course->modules()->createMany([
                ['title' => 'Module 1: Introduction to ODK', 'content' => 'Benefits and challenges of mobile data collection.', 'order' => 1],
                ['title' => 'Module 2: Form Design', 'content' => 'Building XLSForms for complex surveys.', 'order' => 2],
            ]);

            // 5. Create Schedules
            $course->schedules()->createMany([
                [
                    'delivery_mode' => 'online',
                    'start_date' => '2026-07-27',
                    'end_date' => '2026-07-31',
                    'location' => 'Virtual / Zoom',
                    'cost' => 400.00
                ],
                [
                    'delivery_mode' => 'classroom',
                    'start_date' => '2026-08-10',
                    'end_date' => '2026-08-14',
                    'location' => 'Nairobi Training Center',
                    'cost' => 600.00
                ]
            ]);

            // 6. Create FAQs
            $course->faqs()->createMany([
                ['question' => 'Is a laptop required?', 'answer' => 'Yes, for all practical sessions.'],
                ['question' => 'Are there prerequisites?', 'answer' => 'Basic knowledge of Excel is recommended.']
            ]);
        });
    }
}