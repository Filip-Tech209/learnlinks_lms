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
        Schema::create('course_meta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->text('objectives')->nullable();
            $table->text('organizational_impacts')->nullable();
            $table->text('personal_impacts')->nullable();
            $table->string('brochure_path')->nullable();
            $table->text('certification_details')->nullable();
            $table->string('language')->default('English');
            $table->text('requirements')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_metas');
    }
};
