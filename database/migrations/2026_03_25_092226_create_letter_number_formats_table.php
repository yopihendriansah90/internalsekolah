<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('letter_number_formats', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('letter_category_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->string('name');
            $table->string('code', 100)->unique();
            $table->string('format_pattern');
            $table->string('sequence_reset_period', 20)->default('yearly');
            $table->unsignedInteger('current_sequence')->default(0);
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['letter_category_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('letter_number_formats');
    }
};
