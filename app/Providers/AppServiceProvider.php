<?php

// Define the namespace for the service provider
namespace App\Providers;

// Import necessary classes
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Banner;
use App\Models\Setting;

// Define the AppServiceProvider class, which is a core service provider in Laravel
class AppServiceProvider extends ServiceProvider
{  
    // Register any application services
    public function register()
    {
        // This method is used to bind services into the container, but is empty here as no services are registered
    }

    // Bootstrap any application services
    public function boot()
    {
        // Configure the paginator to use Bootstrap styling
        Paginator::useBootstrap();

        // Retrieve banner data and settings data from the database
        $banner_data = Banner::where('id', 1)->first();
        $settings_data = Setting::where('id', 1)->first();

        // Share the banner and settings data globally with all views
        view()->share('global_banner_data', $banner_data);
        view()->share('global_settings_data', $settings_data);
    }
}