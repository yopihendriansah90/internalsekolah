<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('majors', function (Blueprint $table) {
            $table->string('education_level', 10)->default('SMA')->after('short_name');
            $table->string('major_type', 20)->default('jurusan')->after('education_level');

            $table->index(['education_level', 'major_type']);
        });
    }

    public function down(): void
    {
        Schema::table('majors', function (Blueprint $table) {
            $table->dropIndex(['education_level', 'major_type']);
            $table->dropColumn(['education_level', 'major_type']);
        });
    }
};
