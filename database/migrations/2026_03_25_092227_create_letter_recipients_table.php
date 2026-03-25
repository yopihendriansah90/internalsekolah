<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('letter_recipients', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('letter_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('recipient_type', 50)->nullable();
            $table->string('recipient_name');
            $table->string('recipient_position')->nullable();
            $table->text('recipient_address')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            $table->index(['letter_id', 'is_primary']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('letter_recipients');
    }
};
