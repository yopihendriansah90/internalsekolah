<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('letter_signatories', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('letter_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('signatory_name');
            $table->string('signatory_position')->nullable();
            $table->date('signature_date')->nullable();
            $table->string('signature_image_path')->nullable();
            $table->boolean('is_primary')->default(true);
            $table->timestamps();

            $table->index(['letter_id', 'is_primary']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('letter_signatories');
    }
};
