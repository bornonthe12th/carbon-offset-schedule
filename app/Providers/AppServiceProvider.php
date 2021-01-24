<?php

namespace App\Providers;

use App\Impl\CarbonMonthlySchedule;
use App\Impl\MonthlySchedule;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MonthlySchedule::class, CarbonMonthlySchedule::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
