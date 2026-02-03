<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Pagination\Paginator::useBootstrapFive();

        // Share Site Settings with all views using a Composer (Safer)
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $view->with('site_settings', \App\Models\SiteSetting::firstOrCreate([], [
                'announcement_text' => 'WORLDWIDE SHIPPING • PREMIUM AUTOMOTIVE PERFORMANCE • EST. 2026',
                'footer_description' => 'Elite automotive care...'
            ]));
        });
    }
}
