<?php

namespace App\Providers;

use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\Major;
use App\Models\Semester;
use App\Models\StudentClassHistory;
use App\Models\StudentProfile;
use App\Models\Subject;
use App\Models\TeacherProfile;
use App\Models\TeachingAssignment;
use App\Services\Letter\LetterPdfService;
use App\Services\Letter\LetterPlaceholderService;
use App\Services\Letter\LetterTemplateRenderService;
use App\Observers\AcademicYearObserver;
use App\Observers\ClassroomObserver;
use App\Observers\MajorObserver;
use App\Observers\SemesterObserver;
use App\Observers\StudentClassHistoryObserver;
use App\Observers\StudentProfileObserver;
use App\Observers\SubjectObserver;
use App\Observers\TeacherProfileObserver;
use App\Observers\TeachingAssignmentObserver;
use App\Models\User;
use App\Services\Admissions\PpdbAdmissionService;
use App\Services\School\AcademicLabelService;
use App\Services\School\SchoolContextService;
use App\Services\Sync\MasterDataSyncPayloadFactory;
use App\Services\Sync\MasterDataSyncService;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SchoolContextService::class);
        $this->app->singleton(AcademicLabelService::class);
        $this->app->singleton(PpdbAdmissionService::class);
        $this->app->singleton(LetterPlaceholderService::class);
        $this->app->singleton(LetterTemplateRenderService::class);
        $this->app->singleton(LetterPdfService::class);
        $this->app->singleton(MasterDataSyncPayloadFactory::class);
        $this->app->singleton(MasterDataSyncService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        CarbonImmutable::setLocale(config('app.locale'));

        Gate::before(function (User $user, string $ability): ?bool {
            if ($user->hasRole('Super Admin')) {
                return true;
            }

            return null;
        });

        AcademicYear::observe(AcademicYearObserver::class);
        Semester::observe(SemesterObserver::class);
        Major::observe(MajorObserver::class);
        Subject::observe(SubjectObserver::class);
        Classroom::observe(ClassroomObserver::class);
        TeacherProfile::observe(TeacherProfileObserver::class);
        StudentProfile::observe(StudentProfileObserver::class);
        StudentClassHistory::observe(StudentClassHistoryObserver::class);
        TeachingAssignment::observe(TeachingAssignmentObserver::class);
    }
}
