<?php

namespace Kata\Order;

use EventSauce\EventSourcing\AggregateAppliesKnownEvents;
use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;
use Kata\Order\Events\OrderCancelled;
use Kata\Order\Events\OrderMarkedAsReadyForProcessing;
use Kata\Order\Events\OrderPlaced;
use Kata\Order\Events\OrderShipped;
use Kata\Order\Exceptions\SorryOrderCannotBeCancelled;
use Kata\Order\Exceptions\SorryOrderIsAlreadyReadyForProcessing;

class Order implements AggregateRoot
{
    use AggregateRootBehaviour, AggregateAppliesKnownEvents {
        AggregateAppliesKnownEvents::apply as applyKnownEvents;
    }


    private bool $shipped = false;
    private bool $processing = false;

    public function place(): void
    {
        $this->recordThat(new OrderPlaced());
    }

    public function readyForProcessing(): void
    {
        if($this->processing){
            throw new SorryOrderIsAlreadyReadyForProcessing;
        }
        $this->recordThat(new OrderMarkedAsReadyForProcessing());
    }

    public function cancel(): void
    {
        if($this->shipped){
            throw SorryOrderCannotBeCancelled::orderHasAlreadyBeenShipped();
        }
        $this->recordThat(new OrderCancelled());
    }

    public function shipped(): void
    {
        $this->recordThat(new OrderShipped());
    }

    protected function applyOrderShipped(OrderShipped $orderShipped): void
    {
        $this->shipped = true;
    }

    protected function applyOrderMarkedAsReadyForProcessing(OrderMarkedAsReadyForProcessing $orderMarkedAsReadyForProcessing): void
    {
        $this->processing = true;
    }

    protected function apply(object $event): void
    {
        $this->applyKnownEvents($event);
    }
}
