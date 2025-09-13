<?php

namespace App\Providers;

use App\Helpers\SystemHelper;
use App\Interfaces\SystemHelperInterface;
use Tests\Mocks\MockSystemHelper;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SystemHelperInterface::class, SystemHelper::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // $this->app->bind(SystemHelperInterface::class, MockSystemHelper::class);
    }
}
