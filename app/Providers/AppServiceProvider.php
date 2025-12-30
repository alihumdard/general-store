<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {}

    public function boot()
    {
        // View Composer use karein taake har view ko 'siteSettings' mile
        View::composer('*', function ($view) {
            // Fresh data fetch karne ke liye database se direct query
            $settings = Setting::first();
            $view->with('siteSettings', $settings);
        });
    }
}