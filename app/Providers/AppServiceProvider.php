<?php

namespace App\Providers;

use App\CourseBill\CourseBillService;
use App\CourseBill\StudentBillService;
use App\Models\CourseBill;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Sanctum::ignoreMigrations();
        Passport::ignoreMigrations();

        $this->app->singleton(CourseBillService::class, function ($app) {
            return new CourseBillService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('yearmonth', function ($attribute, $value, $parameters, $validator) {
            try {
                Carbon::createFromFormat('Ym', $value);
                return true;
            } catch (\Exception $e) {
                return false;
            }
        });
    }
}
