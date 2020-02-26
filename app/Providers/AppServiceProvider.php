<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Fractal\Facades\Fractal;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fractal::macro('respondJsonApi', function ($statusCode = 200) {
            return $this->respond($statusCode, [
                'Content-Type' => 'application/vnd.api+json',
            ]);
        });
    }
}
