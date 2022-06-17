<?php

namespace Kata\Warehouse\Providers;

use Illuminate\Support\ServiceProvider;
use Kata\Warehouse\CommandHandlers\IncreaseStockHandler;
use Kata\Warehouse\CommandHandlers\OrderShipmentCommandHandler;
use Kata\Warehouse\CommandHandlers\ProcessBackloggedOrdersHandler;
use Kata\Warehouse\CommandHandlers\ProcessOrderShippingHandler;
use Kata\Warehouse\CommandHandlers\ReserveItemsHandler;
use Kata\Warehouse\Commands\IncreaseStock;
use Kata\Warehouse\Commands\MarkOrderAsShipped;
use Kata\Warehouse\Commands\PlaceOrderOnBacklog;
use Kata\Warehouse\Commands\ProcessBackloggedOrders;
use Kata\Warehouse\Commands\ProcessOrderShipping;
use Kata\Warehouse\Commands\ReserveItems;
use Kata\Warehouse\Commands\ShipOrder;
use League\Tactician\Handler\Locator\InMemoryLocator;

class WarehouseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $locator = $this->app->make(InMemoryLocator::class);
        $locator->addHandler($this->app->make(OrderShipmentCommandHandler::class), MarkOrderAsShipped::class);
        $locator->addHandler($this->app->make(OrderShipmentCommandHandler::class), PlaceOrderOnBacklog::class);
        $locator->addHandler($this->app->make(OrderShipmentCommandHandler::class), ShipOrder::class);

        $locator->addHandler($this->app->make(ReserveItemsHandler::class), ReserveItems::class);
        $locator->addHandler($this->app->make(IncreaseStockHandler::class), IncreaseStock::class);
        $locator->addHandler($this->app->make(ProcessOrderShippingHandler::class), ProcessOrderShipping::class);
        $locator->addHandler($this->app->make(ProcessBackloggedOrdersHandler::class), ProcessBackloggedOrders::class);

    }
}
