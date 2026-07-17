<?php

namespace App\Services;

use App\Models\Enrollment;
use App\Models\CourseProgress;
use App\Models\Certificate;
use Illuminate\Support\Facades\DB;

class EnrollmentService
{
    /**
     * Enroll a student in a course and initialize progress trackers for all course modules.
     */
    public function enrollStudent(array $data): Enrollment
    {
        return DB::transaction(function () use ($data) {
            $enrollment = Enrollment::create([
                'student_id'      => $data['student_id'],
                'course_id'       => $data['course_id'],
                'enrollment_date' => $data['enrollment_date'],
                'status'          => 'active',
                'progress_percent'=> 0
            ]);

            // Pull active modules mapped to this course
            $modules = DB::table('course_modules')->where('course_id', $data['course_id'])->get();

            // Populate the progress checklist table for this student enrollment
            foreach ($modules as $module) {
                CourseProgress::create([
                    'enrollment_id' => $enrollment->id,
                    'module_id'     => $module->id,
                    'is_completed'  => false,
                ]);
            }

            return $enrollment;
        });
    }

    /**
     * Mark course modules complete/incomplete and recalculate the progress percentage.
     */
    public function updateProgress(Enrollment $enrollment, array $completedModuleIds): void
    {
        DB::transaction(function () use ($enrollment, $completedModuleIds) {
            // Fetch all initialized progress tracks
            $allProgressLogs = $enrollment->progressLogs;
            $totalModules = $allProgressLogs->count();

            if ($totalModules === 0) {
                // Defensive handling for courses with 0 modules
                $enrollment->update([
                    'progress_percent' => 100,
                    'status' => 'completed'
                ]);
                return;
            }

            foreach ($allProgressLogs as $log) {
                $isCompleted = in_array($log->module_id, $completedModuleIds);
                $log->update([
                    'is_completed' => $isCompleted,
                    'completed_at' => $isCompleted ? now() : null
                ]);
            }

            // Calculate current percentage metrics
            $completedCount = $enrollment->progressLogs()->where('is_completed', true)->count();
            $percentage = (int) round(($completedCount / $totalModules) * 100);

            $status = $enrollment->status;
            if ($percentage === 100) {
                $status = 'completed';
            } elseif ($percentage > 0 && $status === 'enrolled') {
                $status = 'active';
            }

            $enrollment->update([
                'progress_percent' => $percentage,
                'status'           => $status
            ]);
        });
    }

    /**
     * Generate a unique certificate for a fully completed enrollment.
     */
    public function issueCertificate(Enrollment $enrollment, string $grade = 'Pass'): Certificate
    {
        return DB::transaction(function () use ($enrollment, $grade) {
            if ($enrollment->progress_percent < 100) {
                throw new \Exception("Cannot issue certification for an incomplete course.");
            }

            // Generate sequence number (e.g., CERT-2026-00001)
            $year = now()->year;
            $latest = Certificate::whereYear('created_at', $year)->latest()->first();
            $sequence = $latest ? ((int) substr($latest->certificate_number, -5)) + 1 : 1;
            $certNumber = 'CERT-' . $year . '-' . str_pad($sequence, 5, '0', STR_PAD_LEFT);

            return Certificate::create([
                'enrollment_id'      => $enrollment->id,
                'certificate_number' => $certNumber,
                'issue_date'         => now()->format('Y-m-d'),
                'grade'              => $grade
            ]);
        });
    }
}