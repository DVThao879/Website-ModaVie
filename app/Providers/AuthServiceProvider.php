<?php

namespace App\Providers;

use App\Policies\StatisticsPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('view-statistics', [StatisticsPolicy::class, 'viewStatistics']);
        Gate::define('show-statistics', [StatisticsPolicy::class, 'showStatistics']);
    }
}
