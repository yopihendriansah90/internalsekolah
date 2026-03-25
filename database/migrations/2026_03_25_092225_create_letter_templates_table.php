<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('letter_templates', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('letter_category_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->string('name');
            $table->string('code', 100)->unique();
            $table->string('subject_template')->nullable();
            $table->longText('body_html')->nullable();
            $table->json('placeholders')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['letter_category_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('letter_templates');
    }
};
