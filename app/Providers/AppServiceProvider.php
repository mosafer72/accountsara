<?php

namespace App\Providers;

use App\Services\Payments\ZarinpalGateway;
use Illuminate\Support\ServiceProvider;
use App\Services\Sms\SmsProvider;
use App\Services\Sms\KavenegarSmsProvider;
use App\Services\Payments\PaymentGateway;
use App\Services\Payments\IdpayGateway;
use Illuminate\Pagination\Paginator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SmsProvider::class, function () {
            return new KavenegarSmsProvider(config('services.kavenegar.key'));
        });
        $this->app->bind(PaymentGateway::class, function () {
            return new ZarinpalGateway();
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        // Paginator::useBootstrapFour();
        // paginator::defaultView('vendor.pagination.bootstrap-4.blade.php');
    }
}
