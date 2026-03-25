<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('letters', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('letter_category_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('letter_template_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('letter_number_format_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->string('letter_number', 255)->nullable()->unique();
            $table->string('agenda_number', 100)->nullable();
            $table->string('subject');
            $table->string('direction', 30)->default('outgoing');
            $table->date('letter_date')->nullable();
            $table->string('status', 30)->default('draft');
            $table->string('sender_name')->nullable();
            $table->string('recipient_name')->nullable();
            $table->string('signed_by_name')->nullable();
            $table->longText('content')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('signed_at')->nullable();
            $table->timestamp('issued_at')->nullable();
            $table->timestamps();

            $table->index(['letter_category_id', 'status']);
            $table->index(['direction', 'letter_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};
