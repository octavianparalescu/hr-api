<?php

namespace App\Providers;

use App\Entities\Time\Time;
use App\Entities\Time\TimeInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TimeInterface::class, fn() => new Time());
    }
}
