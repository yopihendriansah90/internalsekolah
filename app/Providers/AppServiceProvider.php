<?php

namespace App\Providers;

use App\Services\School\AcademicLabelService;
use App\Services\School\SchoolContextService;
use Carbon\CarbonImmutable;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        CarbonImmutable::setLocale(config('app.locale'));
    }
}
