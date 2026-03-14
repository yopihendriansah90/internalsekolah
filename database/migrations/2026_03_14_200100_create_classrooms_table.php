<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_year_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('major_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->string('name');
            $table->string('grade_level', 10);
            $table->unsignedInteger('capacity')->default(36);
            $table->foreignId('homeroom_teacher_id')->nullable()->constrained('teacher_profiles')->cascadeOnUpdate()->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['academic_year_id', 'name']);
            $table->index(['grade_level', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
