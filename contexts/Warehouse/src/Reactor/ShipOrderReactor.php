<?php

namespace Kata\Warehouse\Reactor;

use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageConsumer;
use Kata\Order\Events\OrderMarkedAsReadyForProcessing;
use Kata\Order\OrderId;
use Kata\Warehouse\Commands\MarkOrderAsShipped;
use Kata\Warehouse\Commands\PlaceOrderOnBacklog;
use Kata\Warehouse\Commands\ProcessBackloggedOrders;
use Kata\Warehouse\Commands\ProcessOrderShipping;
use Kata\Warehouse\Commands\ReserveItems;
use Kata\Warehouse\Commands\ShipOrder;
use Kata\Warehouse\Events\OrderPlacedOnBacklog;
use Kata\Warehouse\Events\OrderShipped;
use Kata\Warehouse\Events\OrderShouldBeShipped;
use Kata\Warehouse\Events\StockIncremented;
use Kata\Warehouse\Exceptions\SorryCannotDecreaseStock;
use Kata\Warehouse\OrderBacklog;
use League\Tactician\CommandBus;

class ShipOrderReactor implements MessageConsumer
{

    public function __construct(protected CommandBus $commandBus)
    {
    }

    public function handle(Message $message): void
    {
        $event = $message->payload();
        if($event instanceof OrderShouldBeShipped){
            $this->commandBus->handle(new ProcessOrderShipping($message->aggregateRootId(), $event->itemCount));
        }

        if($event instanceof OrderMarkedAsReadyForProcessing)
        {
            /** @var OrderId $orderId */
            $orderId = $message->aggregateRootId();
            $this->commandBus->handle(new ShipOrder($orderId));
        }

        if($event instanceof OrderPlacedOnBacklog)
        {
            OrderBacklog::create(['order_id' => $message->aggregateRootId()->toString()]);
        }

        if($event instanceof OrderShipped)
        {
            OrderBacklog::where('order_id', $message->aggregateRootId()->toString())->delete();
        }

        if($event instanceof StockIncremented)
        {
            $this->commandBus->handle(new ProcessBackloggedOrders());
        }


    }
}
