<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['app', 'posts.index'], function ($view) {
            $view->with('user', app('user'));
        });

        view()->composer(['advisors.panel'], function ($view) {
            $view->with('advisor', app('advisor'));
        });

        view()->composer(['trips.sign-out', 'trips.sign-in'], function ($view) {
            $view->with('student', app('student'));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('user', function() {
            return auth()->user();
        });

        $this->app->singleton('advisor', function() {
            return app('user')->advisor;
        });

        $this->app->singleton('student', function() {
            return app('user')->student;
        });
    }
}
