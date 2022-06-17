<?php

namespace Kata\Warehouse;

use EventSauce\EventSourcing\AggregateAppliesKnownEvents;
use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;
use Kata\Warehouse\Commands\MarkOrderAsShipped;
use Kata\Warehouse\Commands\PlaceOrderOnBacklog;
use Kata\Warehouse\Commands\ShipOrder;
use Kata\Warehouse\Events\OrderPlacedOnBacklog;
use Kata\Warehouse\Events\OrderShipped;
use Kata\Warehouse\Events\OrderShouldBeShipped;

class OrderShipment implements AggregateRoot
{
    use AggregateRootBehaviour, AggregateAppliesKnownEvents {
        AggregateAppliesKnownEvents::apply as applyKnownEvents;
    }

    public function handle(object $command): void
    {
        if($command instanceof ShipOrder){
            $this->shipOrder($command);
        }
        if($command instanceof PlaceOrderOnBacklog)
        {
            $this->recordThat(new OrderPlacedOnBacklog($command->reason));
        }
        if($command instanceof MarkOrderAsShipped)
        {
            $this->recordThat(new OrderShipped());
        }
    }

    public function shipOrder(ShipOrder $command)
    {
        $this->recordThat(new OrderShouldBeShipped($command->orderId));
    }

    protected function apply(object $event): void
    {
        $this->applyKnownEvents($event);
    }


}
