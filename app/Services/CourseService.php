<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseService
{
    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Handle Course Cover Image
            $imagePath = null;
            if (isset($data['image']) && $data['image']->isValid()) {
                $imagePath = $data['image']->store('courses/images', 'public');
            }

            $course = Course::create([
                'category_id'     => $data['category_id'],
                'title'           => $data['title'],
                'slug'            => Str::slug($data['title']),
                'description'     => $data['description'] ?? null,
                'delivery_method' => $data['delivery_method'],
                'duration'        => $data['duration'],
                'base_price'      => $data['base_price'] ?: null,
                'featured_image'  => $imagePath,
            ]);

            // Handle Course Brochure inside Meta
            $metaData = $data['meta'] ?? [];
            if (isset($data['brochure']) && $data['brochure']->isValid()) {
                $metaData['brochure_path'] = $data['brochure']->store('courses/brochures', 'public');
            }
            $course->meta()->create($metaData);

            if (!empty($data['modules'])) {
                $course->modules()->createMany($this->cleanRelationArray($data['modules']));
            }
            
            if (!empty($data['schedules'])) {
                $course->schedules()->createMany($this->cleanRelationArray($data['schedules']));
            }
            
            if (!empty($data['faqs'])) {
                $course->faqs()->createMany($this->cleanRelationArray($data['faqs']));
            }

            return $course;
        });
    }

    public function update(Course $course, array $data)
    {
        return DB::transaction(function () use ($course, $data) {
            // Handle Course Cover Image Update
            $imagePath = $course->image_path;
            if (isset($data['image']) && $data['image']->isValid()) {
                if ($course->image_path) {
                    Storage::disk('public')->delete($course->image_path);
                }
                $imagePath = $data['image']->store('courses/images', 'public');
            }

            $course->update([
                'category_id'     => $data['category_id'],
                'title'           => $data['title'],
                'slug'            => Str::slug($data['title']),
                'description'     => $data['description'] ?? null,
                'delivery_method' => $data['delivery_method'],
                'duration'        => $data['duration'],
                'base_price'      => $data['base_price'] ?: null,
                'featured_image'  => $imagePath,
            ]);

            // Handle Course Brochure PDF Update
            $metaData = $data['meta'] ?? [];
            if (isset($data['brochure']) && $data['brochure']->isValid()) {
                if ($course->meta && $course->meta->brochure_path) {
                    Storage::disk('public')->delete($course->meta->brochure_path);
                }
                $metaData['brochure_path'] = $data['brochure']->store('courses/brochures', 'public');
            }
            $course->meta()->updateOrCreate(['course_id' => $course->id], $metaData);

            // Sync dynamic lists safely (checking existence to prevent wiping out unsubmitted lists)
            if (array_key_exists('modules', $data)) {
                $this->syncRelation($course->modules(), $data['modules'] ?? []);
            }
            
            if (array_key_exists('schedules', $data)) {
                $this->syncRelation($course->schedules(), $data['schedules'] ?? []);
            }

            if (array_key_exists('faqs', $data)) {
                $this->syncRelation($course->faqs(), $data['faqs'] ?? []);
            }

            return $course;
        });
    }

    private function syncRelation($relation, array $data)
    {
        // 1. Safely extract valid, non-empty submitted database record IDs
        $submittedIds = collect($data)
            ->pluck('id')
            ->filter(fn($id) => !is_null($id) && $id !== '' && $id !== 'null')
            ->all();
        
        // 2. Delete database entries that are no longer in the submitted list
        $relation->whereNotIn('id', $submittedIds)->delete();
        
        // 3. Loop and cleanly apply updates/inserts
        foreach ($data as $item) {
            $id = $item['id'] ?? null;
            
            // Convert any blank form inputs to clean database NULL values
            $cleanItem = collect($item)->map(fn($v) => $v === '' ? null : $v)->except('id')->toArray();
            
            if ($id && $id !== 'null' && $id !== '') {
                // Keep the old database record and update it safely
                $relation->where('id', $id)->update($cleanItem);
            } else {
                // Create a completely new child database record
                $relation->create($cleanItem);
            }
        }
    }

    /**
     * Cleans up relation arrays during "Store" to strip blank IDs and map empty strings to null
     */
    private function cleanRelationArray(array $items): array
    {
        return array_map(function ($item) {
            return collect($item)
                ->map(fn($v) => $v === '' ? null : $v)
                ->except('id')
                ->toArray();
        }, $items);
    }
}