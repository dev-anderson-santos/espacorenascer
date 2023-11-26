<?php

namespace App\Providers;

use App\User;
use App\Models\ScheduleModel;
use App\Models\SchedulesNextMonthModel;
use App\Observers\UserObserver;
use App\Observers\ScheduleObserver;
use App\Observers\SchedulesNextMonthObserver;
use Illuminate\Support\Facades\Schema;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Necessário pois foi selecionada a codificação utf8 mbstring 
        Schema::defaultStringLength(191);

        User::observe(UserObserver::class);
        ScheduleModel::observe(ScheduleObserver::class);
        SchedulesNextMonthModel::observe((SchedulesNextMonthObserver::class));
    }
}
