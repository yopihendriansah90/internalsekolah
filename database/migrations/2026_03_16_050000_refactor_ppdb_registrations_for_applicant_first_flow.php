<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ppdb_registrations', function (Blueprint $table): void {
            $table->foreignId('major_id')
                ->nullable()
                ->after('student_profile_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('full_name')->nullable()->after('registration_number');
            $table->string('nisn', 50)->nullable()->after('full_name');
            $table->string('birth_place', 100)->nullable()->after('nisn');
            $table->date('birth_date')->nullable()->after('birth_place');
            $table->string('gender', 20)->nullable()->after('birth_date');
            $table->string('religion', 50)->nullable()->after('gender');
            $table->string('phone', 50)->nullable()->after('religion');
            $table->string('email')->nullable()->after('phone');
            $table->text('address')->nullable()->after('email');
            $table->string('guardian_name', 255)->nullable()->after('address');
            $table->string('guardian_phone', 50)->nullable()->after('guardian_name');
        });

        DB::table('ppdb_registrations')
            ->select(['id', 'student_profile_id'])
            ->whereNotNull('student_profile_id')
            ->orderBy('id')
            ->each(function (object $registration): void {
                $student = DB::table('student_profiles')
                    ->where('id', $registration->student_profile_id)
                    ->first([
                        'major_id',
                        'full_name',
                        'nisn',
                        'birth_place',
                        'birth_date',
                        'gender',
                        'religion',
                        'phone',
                        'email',
                        'address',
                        'guardian_name',
                        'guardian_phone',
                    ]);

                if (! $student) {
                    return;
                }

                DB::table('ppdb_registrations')
                    ->where('id', $registration->id)
                    ->update([
                        'major_id' => $student->major_id,
                        'full_name' => $student->full_name,
                        'nisn' => $student->nisn,
                        'birth_place' => $student->birth_place,
                        'birth_date' => $student->birth_date,
                        'gender' => $student->gender,
                        'religion' => $student->religion,
                        'phone' => $student->phone,
                        'email' => $student->email,
                        'address' => $student->address,
                        'guardian_name' => $student->guardian_name,
                        'guardian_phone' => $student->guardian_phone,
                    ]);
            });

        Schema::table('ppdb_registrations', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('student_profile_id');
        });

        Schema::table('ppdb_registrations', function (Blueprint $table): void {
            $table->foreignId('student_profile_id')
                ->nullable()
                ->after('id')
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('ppdb_registrations', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('student_profile_id');
        });

        Schema::table('ppdb_registrations', function (Blueprint $table): void {
            $table->foreignId('student_profile_id')
                ->after('id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->dropConstrainedForeignId('major_id');
            $table->dropColumn([
                'full_name',
                'nisn',
                'birth_place',
                'birth_date',
                'gender',
                'religion',
                'phone',
                'email',
                'address',
                'guardian_name',
                'guardian_phone',
            ]);
        });
    }
};
