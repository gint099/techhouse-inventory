<?php

namespace App\Providers;

use App\View\Composers\NavbarComposer;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
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
        if (config('app.env') === 'local' && ($appUrl = config('app.url'))) {
            URL::forceRootUrl($appUrl);
        }

        View::composer('partials.navbar', NavbarComposer::class);
    }
}
