<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->unique()->constrained()->onDelete('cascade');
            $table->string('certificate_number')->unique(); // E.g. CERT-2026-00001
            $table->date('issue_date');
            $table->string('grade', 5)->nullable(); // E.g. A+, Pass, Dist.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};