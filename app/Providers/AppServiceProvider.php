<?php
namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View; // Yeh line add karein
use Illuminate\Support\ServiceProvider;
// Yeh line add karein

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {}

    public function boot()
    {
        // Ye code ensure karega ke 'siteSettings' variable har sidebar ko mile
       View::composer('*', function ($view) {
        $view->with('siteSettings', Setting::first());
    });
    }
}
