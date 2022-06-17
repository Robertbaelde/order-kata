<?php

namespace Kata\PurchaseOrder\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Kata\PurchaseOrder\CommandHandlers\PlacePurchaseOrderHandler;
use Kata\PurchaseOrder\CommandHandlers\TrustCompanyHandler;
use Kata\PurchaseOrder\Commands\PlacePurchaseOrder;
use Kata\PurchaseOrder\Commands\TrustCompany;
use League\Tactician\Handler\Locator\InMemoryLocator;

class PurchaseOrderServiceProvider extends ServiceProvider
{
    public function register()
    {
        $locator = $this->app->make(InMemoryLocator::class);
        $locator->addHandler($this->app->make(PlacePurchaseOrderHandler::class), PlacePurchaseOrder::class);
        $locator->addHandler($this->app->make(TrustCompanyHandler::class), TrustCompany::class);
    }
}
