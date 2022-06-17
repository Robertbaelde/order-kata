<?php

namespace Kata\Payments\Providers;

use Illuminate\Support\ServiceProvider;
use Kata\Payments\CommandHandlers\AuthorizePaymentHandler;
use Kata\Payments\CommandHandlers\SelectPaymentMethodHandler;
use Kata\Payments\Commands\AuthorizePayment;
use Kata\Payments\Commands\SelectPaymentMethod;
use League\Tactician\Handler\Locator\InMemoryLocator;

class PaymentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $locator = $this->app->make(InMemoryLocator::class);
        $locator->addHandler($this->app->make(SelectPaymentMethodHandler::class), SelectPaymentMethod::class);
        $locator->addHandler($this->app->make(AuthorizePaymentHandler::class), AuthorizePayment::class);
    }
}
