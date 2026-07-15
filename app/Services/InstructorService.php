<?php

namespace App\Services;

use App\Models\Instructor;
use Illuminate\Support\Facades\DB;

class InstructorService
{
    /**
     * Store a new instructor with detailed profile and optional certifications.
     */
    public function store(array $data): Instructor
    {
        return DB::transaction(function () use ($data) {
            // A. Create main record
            $instructor = Instructor::create($data['instructor']);

            // B. Create sub-detail details
            $instructor->detail()->create($data['detail'] ?? []);

            // C. Create certifications
            if (!empty($data['certifications'])) {
                foreach ($data['certifications'] as $cert) {
                    if (!empty($cert['name'])) {
                        $instructor->certifications()->create($cert);
                    }
                }
            }

            return $instructor;
        });
    }

    /**
     * Update existing records across all three tables safely.
     */
    public function update(Instructor $instructor, array $data): Instructor
    {
        return DB::transaction(function () use ($instructor, $data) {
            // A. Update core instructor
            $instructor->update($data['instructor']);

            // B. Update/Create structural profile details
            $instructor->detail()->updateOrCreate([], $data['detail'] ?? []);

            // C. Sync certifications safely
            $this->syncCertifications($instructor->certifications(), $data['certifications'] ?? []);

            return $instructor;
        });
    }

    /**
     * Safely drop relations and clean out records.
     */
    public function delete(Instructor $instructor): void
    {
        DB::transaction(function () use ($instructor) {
            $instructor->delete(); // Cascade rules in migration will clean child rows automatically
        });
    }

    /**
     * Clones the active relation thread to prevent cross-contamination within loops.
     */
    private function syncCertifications($relation, array $data): void
    {
        $submittedIds = collect($data)
            ->pluck('id')
            ->filter(fn($id) => !is_null($id) && $id !== '' && $id !== 'null')
            ->all();

        // Remove certifications no longer present in UI state
        (clone $relation)->whereNotIn('id', $submittedIds)->delete();

        foreach ($data as $item) {
            $id = $item['id'] ?? null;
            $cleanItem = collect($item)->except('id')->toArray();

            if (empty($cleanItem['name'])) {
                continue; // Skip blank templates
            }

            if ($id && $id !== 'null' && $id !== '') {
                (clone $relation)->where('id', $id)->update($cleanItem);
            } else {
                (clone $relation)->create($cleanItem);
            }
        }
    }
}