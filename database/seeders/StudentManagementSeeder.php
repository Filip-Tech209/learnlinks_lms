<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\StudentDetail;
use App\Models\EmergencyContact;
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
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Faker::create();

        // 2. Generate 25 realistic student profiles
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

            // Generate sequential registration numbers matching the current year (2026)
            $studentNumber = 'LL/00' . $i . '/2026';

            // A. Seed the primary student identity record
            $student = Student::create([
                'student_number'  => $studentNumber,
                'first_name'      => $firstName,
                'last_name'       => $lastName,
                'email'           => $email,
                'phone'           => $faker->phoneNumber,
                'status'          => $faker->randomElement(['active', 'active', 'active', 'inactive', 'suspended']), // Weighted active
                'enrollment_date' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
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
                    null // Allow some null fields to test empty-state views
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
        }
    }
}