<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('course_categories')->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique(); // Professional requirement for URLs
            $table->text('description'); // The main 'About' summary
            $table->string('featured_image')->nullable();
            $table->string('delivery_method'); // e.g., online, classroom, hybrid
            $table->string('duration'); // e.g., '5 Days', '2 Weeks
            $table->decimal('base_price', 10, 2)->default(0.00); // Standardize pricing
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
