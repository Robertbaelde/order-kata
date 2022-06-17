<?php

namespace Kata\Warehouse\Infra;

use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\ClassNameInflector;
use EventSauce\EventSourcing\EventSourcedAggregateRootRepository;
use EventSauce\EventSourcing\MessageDecorator;
use EventSauce\EventSourcing\MessageDispatcher;
use EventSauce\EventSourcing\SynchronousMessageDispatcher;
use EventSauce\MessageRepository\IlluminateMessageRepository\IlluminateUuidV4MessageRepository;
use Kata\Order\Infra\DefaultTableSchema;
use Kata\Order\OrderId;
use Kata\Warehouse\OrderShipment;
use Kata\Warehouse\Reactor\ShipOrderReactor;

class OrderShipmentRepository  extends EventSourcedAggregateRootRepository
{
    public function __construct(
        MessageDispatcher $dispatcher = null,
        MessageDecorator $decorator = null,
        ClassNameInflector $classNameInflector = null
    ) {
        parent::__construct(
            OrderShipment::class,
            resolve(IlluminateUuidV4MessageRepository::class, [
               'tableName' => 'order_shipment_events',
                'tableSchema' => new DefaultTableSchema(),
            ]),
            new SynchronousMessageDispatcher(
                resolve(ShipOrderReactor::class),
            ),
            $decorator,
            $classNameInflector
        );
    }

    public function retrieve(AggregateRootId | OrderId $orderId): OrderShipment
    {
        return parent::retrieve($orderId);
    }

    public function persist(object $itemInventory): void
    {
        if(!$itemInventory instanceof OrderShipment){
            throw new \Exception("what are you doing?");
        }
        parent::persist($itemInventory);
    }
}
