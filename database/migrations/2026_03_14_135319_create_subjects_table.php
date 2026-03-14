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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('education_level', 20)->nullable();
            $table->string('school_type_scope', 20)->default('ALL');
            $table->string('subject_group', 30)->default('umum');
            $table->foreignId('major_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->boolean('is_productive')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['school_type_scope', 'subject_group']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
