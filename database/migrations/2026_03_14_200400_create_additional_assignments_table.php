<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('additional_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_profile_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('assignment_type', 100);
            $table->foreignId('classroom_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['assignment_type', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('additional_assignments');
    }
};
