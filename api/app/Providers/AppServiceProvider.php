<?php

namespace App\Providers;

use App\Services\AuthService;
use App\Services\BookService;
use App\Services\CacheService;
use App\Services\UserService;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register auth service
        $this->app->singleton(AuthService::class, function ($app) {
            return new AuthService();
        });
        // Register book service
        $this->app->singleton(BookService::class, function ($app) {
            $cacheService = new CacheService();
            return new BookService($cacheService);
        });
        // Register user service
        $this->app->singleton(UserService::class, function ($app) {
            return new UserService();
        });

        // // Register cache service
        $this->app->singleton(CacheService::class, function ($app) {
            return new CacheService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
