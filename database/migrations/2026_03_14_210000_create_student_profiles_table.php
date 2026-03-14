<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('nis', 50)->unique();
            $table->string('nisn', 50)->nullable()->unique();
            $table->string('dapodik_id', 100)->nullable()->unique();
            $table->string('registration_number', 100)->nullable()->unique();
            $table->foreignId('major_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->string('full_name');
            $table->string('birth_place', 100)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('religion', 50)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('guardian_name', 255)->nullable();
            $table->string('guardian_phone', 50)->nullable();
            $table->unsignedSmallInteger('entry_year')->nullable();
            $table->string('student_status', 30)->default('aktif');
            $table->string('ppdb_status', 30)->default('draft');
            $table->unsignedSmallInteger('graduation_year')->nullable();
            $table->boolean('is_alumni')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['student_status', 'is_alumni']);
            $table->index(['major_id', 'entry_year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
