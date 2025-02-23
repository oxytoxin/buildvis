<?php

namespace App\Providers;

use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Schema;

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
        Model::unguard();
        Model::preventLazyLoading(! app()->isProduction());
        Model::preventsAccessingMissingAttributes(! app()->isProduction());
        Schema::defaultStringLength(191);
        DatePicker::configureUsing(function (DatePicker $datePicker) {
            $datePicker->native(false)->closeOnDateSelection(true);
        });
    }
}
