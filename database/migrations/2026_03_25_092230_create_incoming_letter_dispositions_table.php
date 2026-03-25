<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incoming_letter_dispositions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('letter_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('from_user_id')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('to_user_id')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->text('instruction');
            $table->date('due_date')->nullable();
            $table->string('status', 30)->default('pending');
            $table->timestamp('read_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['to_user_id', 'status']);
            $table->index(['due_date', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incoming_letter_dispositions');
    }
};
