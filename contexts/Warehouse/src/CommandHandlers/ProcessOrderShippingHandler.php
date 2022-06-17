<?php

namespace Kata\Warehouse\CommandHandlers;

use Kata\Warehouse\Commands\MarkOrderAsShipped;
use Kata\Warehouse\Commands\PlaceOrderOnBacklog;
use Kata\Warehouse\Commands\ProcessOrderShipping;
use Kata\Warehouse\Commands\ReserveItems;
use Kata\Warehouse\Exceptions\SorryCannotDecreaseStock;
use League\Tactician\CommandBus;

class ProcessOrderShippingHandler
{
    public function __construct(
        protected CommandBus $commandBus
    )
    {
    }

    public function handle(ProcessOrderShipping $command)
    {
        try {
            $this->commandBus->handle(new ReserveItems($command->itemCount));
        } catch (SorryCannotDecreaseStock $sorryCannotDecreaseStock)
        {
            $this->commandBus->handle(new PlaceOrderOnBacklog($command->orderId, "products not in stock"));
            return;
        }
        $this->commandBus->handle(new MarkOrderAsShipped($command->orderId));
    }
}
