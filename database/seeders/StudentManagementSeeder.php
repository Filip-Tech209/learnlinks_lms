<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\StudentDetail;
use App\Models\EmergencyContact;
use App\Models\Enrollment;
use App\Models\CourseProgress;
use App\Models\Certificate;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StudentManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Clear out existing records to prevent unique constraint conflicts
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Student::truncate();
        StudentDetail::truncate();
        EmergencyContact::truncate();
        Enrollment::truncate();
        CourseProgress::truncate();
        Certificate::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Faker::create();

        // 2. Safeguard: Fetch existing courses. If none exist, auto-seed a couple of fallbacks
        $courses = DB::table('courses')->get();
        if ($courses->isEmpty()) {
            $this->seedFallbackCourses();
            $courses = DB::table('courses')->get();
        }

        $certificateCounter = 1;

        // 3. Generate 25 realistic student profiles
        for ($i = 1; $i <= 25; $i++) {
            $gender = $faker->randomElement(['male', 'female', 'other', 'prefer_not_to_say']);
            
            // Align first name with chosen gender option
            $firstName = match($gender) {
                'male' => $faker->firstNameMale,
                'female' => $faker->firstNameFemale,
                default => $faker->firstName,
            };
            $lastName = $faker->lastName;
            
            // Generate unique professional emails based on their name
            $email = strtolower($firstName . '.' . $lastName . '.' . $faker->unique()->numberBetween(10, 99) . '@example.com');

            // Generate sequential registration numbers matching your format (padded nicely for triple digits)
            $studentNumber = 'LL/' . str_pad($i, 3, '0', STR_PAD_LEFT) . '/2026';

            // A. Seed the primary student identity record
            $student = Student::create([
                'student_number' => $studentNumber,
                'first_name'     => $firstName,
                'last_name'      => $lastName,
                'email'          => $email,
                'phone'          => $faker->phoneNumber,
                'status'         => $faker->randomElement(['active', 'active', 'active', 'inactive', 'suspended']),
                'admission_date' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            ]);

            // B. Seed the deep-dive profile details (1-to-1 relationship)
            StudentDetail::create([
                'student_id'              => $student->id,
                'date_of_birth'           => $faker->dateTimeBetween('-30 years', '-18 years')->format('Y-m-d'),
                'gender'                  => $gender,
                'address'                 => $faker->address,
                'national_id_or_passport' => $faker->bothify('ID-######??'),
                'academic_background'     => $faker->randomElement([
                    "Graduated with honors from " . $faker->company . " Secondary School.",
                    "Transferred from local polytechnic institute. Completed foundation courses.",
                    "Holds a prior diploma in business applications.",
                    "Self-taught professional looking to build formal qualifications.",
                    null
                ]),
            ]);

            // C. Seed emergency contacts (1-to-2 dynamic relationships per student)
            $contactCount = $faker->numberBetween(1, 2);
            for ($j = 0; $j < $contactCount; $j++) {
                EmergencyContact::create([
                    'student_id'   => $student->id,
                    'name'         => $faker->name,
                    'relationship' => $faker->randomElement(['Parent', 'Guardian', 'Spouse', 'Sibling', 'Uncle/Aunt']),
                    'phone'        => $faker->phoneNumber,
                    'email'        => $faker->safeEmail,
                ]);
            }

            // D. Academic Lifecycle: Enroll this student in 1 or 2 random courses
           $courseArray = $courses->toArray();

$courseCount = min(
    count($courseArray),
    $faker->numberBetween(1, 2)
);

$enrolledCourses = $faker->randomElements($courseArray, $courseCount);

            foreach ($enrolledCourses as $course) {
                $lifecycleStatus = $faker->randomElement(['enrolled', 'active', 'completed']);
                
                $enrollment = Enrollment::create([
                    'student_id'       => $student->id,
                    'course_id'        => $course->id,
                    'enrollment_date'  => $faker->dateTimeBetween($student->admission_date, 'now')->format('Y-m-d'),
                    'status'           => $lifecycleStatus,
                    'progress_percent' => 0,
                ]);

                // Query associated modules from the course_modules table
                $modules = DB::table('course_modules')->where('course_id', $course->id)->get();
                $totalModules = $modules->count();
                $completedModulesCount = 0;

                foreach ($modules as $module) {
                    $isModuleCompleted = match ($lifecycleStatus) {
                        'completed' => true,
                        'enrolled'  => false,
                        'active'    => $faker->boolean(60), // 60% completion rate for active tracks
                    };

                    if ($isModuleCompleted) {
                        $completedModulesCount++;
                    }

                    CourseProgress::create([
                        'enrollment_id' => $enrollment->id,
                        'module_id'     => $module->id,
                        'is_completed'  => $isModuleCompleted,
                        'completed_at'  => $isModuleCompleted ? $faker->dateTimeBetween($enrollment->enrolled_at, 'now') : null,
                    ]);
                }

                // Calculate real normalized progress weight matching actual modules completed
                $progressPercent = $totalModules > 0 ? (int) round(($completedModulesCount / $totalModules) * 100) : 100;
                $finalStatus = $progressPercent === 100 ? 'completed' : $lifecycleStatus;

                $enrollment->update([
                    'progress_percent' => $progressPercent,
                    'status'           => $finalStatus,
                ]);

                // E. Graduation Verification: Issue secure tracking certificate if progress hits 100%
                if ($progressPercent === 100) {
                    Certificate::create([
                        'enrollment_id'      => $enrollment->id,
                        'certificate_number' => 'CERT-2026-' . str_pad($certificateCounter++, 5, '0', STR_PAD_LEFT),
                        'issue_date'         => $faker->dateTimeBetween($enrollment->enrolled_at, 'now')->format('Y-m-d'),
                        'grade'              => $faker->randomElement(['Distinction', 'Merit', 'Pass']),
                    ]);
                }
            }
        }
    }

    /**
     * Internal helper to build dummy courses/modules if database is clear.
     */
    private function seedFallbackCourses(): void
    {
        $course1 = DB::table('courses')->insertGetId([
            'title'           => 'Master Class in Laravel',
            'description'     => 'Advanced backend system engineering concepts.',
            'delivery_method' => 'Hybrid',
            'duration'        => '5 Days',
            'base_price'      => 450,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        $course2 = DB::table('courses')->insertGetId([
            'title'           => 'Flutter Mobile Architecture',
            'description'     => 'Enterprise class cross-platform native programming.',
            'delivery_method' => 'Online',
            'duration'        => '10 Days',
            'base_price'      => 600,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        DB::table('course_modules')->insert([
            ['course_id' => $course1, 'title' => 'Laravel Routing Stack', 'order' => 1, 'content' => 'Deep dive into routers.', 'created_at' => now(), 'updated_at' => now()],
            ['course_id' => $course1, 'title' => 'Advanced Eloquent Architecture', 'order' => 2, 'content' => 'Database relationships optimization.', 'created_at' => now(), 'updated_at' => now()],
            ['course_id' => $course2, 'title' => 'State Management Paradigms', 'order' => 1, 'content' => 'Building complex app scopes.', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}