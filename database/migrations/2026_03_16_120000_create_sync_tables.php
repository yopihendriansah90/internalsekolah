<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sync_batches', function (Blueprint $table) {
            $table->uuid('batch_id')->primary();
            $table->string('target_system', 50)->default('edu');
            $table->string('status', 20)->default('pending');
            $table->unsignedInteger('total_items')->default(0);
            $table->unsignedInteger('success_items')->default(0);
            $table->unsignedInteger('failed_items')->default(0);
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->text('last_error')->nullable();
            $table->timestamps();

            $table->index(['target_system', 'status']);
        });

        Schema::create('sync_outbox', function (Blueprint $table) {
            $table->id();
            $table->uuid('batch_id');
            $table->string('entity', 100);
            $table->string('record_id', 100);
            $table->string('operation', 20);
            $table->json('payload');
            $table->string('payload_hash', 128)->nullable();
            $table->string('status', 20)->default('pending');
            $table->unsignedInteger('attempt_count')->default(0);
            $table->timestamp('available_at')->nullable();
            $table->timestamp('locked_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('source_updated_at')->nullable();
            $table->text('last_error')->nullable();
            $table->timestamps();

            $table->foreign('batch_id')
                ->references('batch_id')
                ->on('sync_batches')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->index(['status', 'available_at']);
            $table->index(['entity', 'record_id']);
            $table->index(['batch_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sync_outbox');
        Schema::dropIfExists('sync_batches');
    }
};
