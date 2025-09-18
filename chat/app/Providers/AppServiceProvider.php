<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ChatExportService;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ChatExportService::class);
    }
  

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
