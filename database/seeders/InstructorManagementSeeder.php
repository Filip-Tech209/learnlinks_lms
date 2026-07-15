<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Instructor;
use App\Models\InstructorDetail;
use App\Models\InstructorCertification;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class InstructorManagementSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Instructor::truncate();
        InstructorDetail::truncate();
        InstructorCertification::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Faker::create();

        $specialties = [
            'Laravel Development', 'Flutter Mobile Frameworks', 'System Architecture',
            'Next.js UI/UX Design', 'Database Administration', 'DevOps & AWS Infrastructures'
        ];

        $certNames = [
            ['AWS Certified Solutions Architect', 'Amazon Web Services'],
            ['Laravel Certified Developer', 'Laravel LLC'],
            ['Google Certified Professional Cloud Architect', 'Google Cloud'],
            ['Certified Information Systems Security Professional', 'ISC2']
        ];

        for ($i = 1; $i <= 15; $i++) {
            $gender = $faker->randomElement(['male', 'female', 'other', 'prefer_not_to_say']);
            $firstName = match($gender) {
                'male' => $faker->firstNameMale,
                'female' => $faker->firstNameFemale,
                default => $faker->firstName,
            };
            $lastName = $faker->lastName;
            $email = strtolower($firstName . '.' . $lastName . '.' . $faker->unique()->numberBetween(10, 99) . '@zambezischool.com');

            $instructor = Instructor::create([
                'instructor_number' => 'INS-2026-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone' => $faker->phoneNumber,
                'status' => $faker->randomElement(['active', 'active', 'inactive', 'suspended']),
                'hire_date' => $faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
            ]);

            InstructorDetail::create([
                'instructor_id' => $instructor->id,
                'date_of_birth' => $faker->dateTimeBetween('-55 years', '-25 years')->format('Y-m-d'),
                'gender' => $gender,
                'address' => $faker->address,
                'qualifications' => $faker->paragraph(2),
                'specialty' => $faker->randomElement($specialties),
            ]);

            // Assign 1 to 2 certifications to each instructor
            $certsToCreate = $faker->numberBetween(1, 2);
            $chosenCerts = $faker->randomElements($certNames, $certsToCreate);

            foreach ($chosenCerts as $cert) {
                InstructorCertification::create([
                    'instructor_id' => $instructor->id,
                    'name' => $cert[0],
                    'issuing_authority' => $cert[1],
                    'attained_date' => $faker->dateTimeBetween('-4 years', 'now')->format('Y-m-d'),
                ]);
            }
        }
    }
}