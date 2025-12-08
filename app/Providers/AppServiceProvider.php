<?php

namespace App\Providers;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\ServiceProvider;
use App\Models\DocumentRequest;
use App\Observers\DocumentRequestObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    

    public function boot(): void
    {
        Sanctum::ignoreMigrations();
        
        // Register observers
        DocumentRequest::observe(DocumentRequestObserver::class);
    }


    /**
     * Bootstrap any application services.
     */
   
}
