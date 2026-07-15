<?php

namespace App\Services;

use App\Models\Student;
use Illuminate\Support\Facades\DB;

class StudentService
{
    public function store(array $data): Student
    {
        return DB::transaction(function () use ($data) {
            // Auto-generate a sequential registration number (e.g. LL0001, LL00027, etc.) 
            $data['student_number'] = $this->generateStudentNumber();

            $student = Student::create([
                'student_number'  => $data['student_number'],
                'first_name'      => $data['first_name'],
                'last_name'       => $data['last_name'],
                'email'           => $data['email'],
                'phone'           => $data['phone'] ?? null,
                'status'          => $data['status'] ?? 'active',
                'enrollment_date' => $data['enrollment_date'],
            ]);

            $student->details()->create($data['details'] ?? []);

            if (!empty($data['emergency_contacts'])) {
                $student->emergencyContacts()->createMany($this->cleanRelationArray($data['emergency_contacts']));
            }

            return $student;
        });
    }

    public function update(Student $student, array $data): Student
    {
        return DB::transaction(function () use ($student, $data) {
            $student->update([
                'first_name'      => $data['first_name'],
                'last_name'       => $data['last_name'],
                'email'           => $data['email'],
                'phone'           => $data['phone'] ?? null,
                'status'          => $data['status'] ?? 'active',
                'enrollment_date' => $data['enrollment_date'],
            ]);

            $student->details()->updateOrCreate(['student_id' => $student->id], $data['details'] ?? []);

            if (array_key_exists('emergency_contacts', $data)) {
                $this->syncRelation($student->emergencyContacts(), $data['emergency_contacts'] ?? []);
            }

            return $student;
        });
    }

    private function syncRelation($relation, array $data)
    {
        // 1. Filter out empty IDs to secure active records
        $submittedIds = collect($data)
            ->pluck('id')
            ->filter(fn($id) => !is_null($id) && $id !== '' && $id !== 'null')
            ->all();

        // 2. Clear out missing options using a cloned instance
        (clone $relation)->whereNotIn('id', $submittedIds)->delete();

        // 3. Process records safely using fresh clones to prevent WHERE clause accumulation
        foreach ($data as $item) {
            $id = $item['id'] ?? null;
            $cleanItem = collect($item)->map(fn($v) => $v === '' ? null : $v)->except('id')->toArray();

            if ($id && $id !== 'null' && $id !== '') {
                // Cloned to preserve the student_id relationship scope without cross-contaminating the loop
                (clone $relation)->where('id', $id)->update($cleanItem);
            } else {
                (clone $relation)->create($cleanItem);
            }
        }
    }

    private function cleanRelationArray(array $items): array
    {
        return array_map(function ($item) {
            return collect($item)
                ->map(fn($v) => $v === '' ? null : $v)
                ->except('id')
                ->toArray();
        }, $items);
    }

    private function generateStudentNumber(): string
    {
        $year = now()->year;

        // Get the last student number created this year
        $latest = Student::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        if ($latest && preg_match('/LL\/(\d+)\/\d{4}/', $latest->student_number, $matches)) {
            $sequence = (int) $matches[1] + 1;
        } else {
            $sequence = 1;
        }

        return 'LL/' . str_pad($sequence, 3, '0', STR_PAD_LEFT) . '/' . $year;
    }
}