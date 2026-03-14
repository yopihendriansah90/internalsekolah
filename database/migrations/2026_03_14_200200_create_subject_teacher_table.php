<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subject_teacher', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_profile_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('academic_year_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->text('competency_notes')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['teacher_profile_id', 'subject_id', 'academic_year_id'], 'subject_teacher_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subject_teacher');
    }
};
