<?php

namespace Kata\Warehouse\CommandHandlers;

use Kata\Order\OrderId;
use Kata\Warehouse\Commands\ProcessBackloggedOrders;
use Kata\Warehouse\Commands\ProcessOrderShipping;
use Kata\Warehouse\OrderBacklog;
use League\Tactician\CommandBus;

class ProcessBackloggedOrdersHandler
{
    public function __construct(
        protected CommandBus $commandBus
    )
    {
    }

    public function handle(ProcessBackloggedOrders $processBackloggedOrders)
    {
        $nextOrder = OrderBacklog::first();
        $this->commandBus->handle(new ProcessOrderShipping(OrderId::fromString($nextOrder->order_id), 1));

    }
}
