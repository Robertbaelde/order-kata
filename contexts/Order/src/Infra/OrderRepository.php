<?php

namespace Kata\Order\Infra;

use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\ClassNameInflector;
use EventSauce\EventSourcing\EventSourcedAggregateRootRepository;
use EventSauce\EventSourcing\MessageDecorator;
use EventSauce\EventSourcing\MessageDispatcher;
use EventSauce\EventSourcing\SynchronousMessageDispatcher;
use EventSauce\MessageRepository\IlluminateMessageRepository\IlluminateUuidV4MessageRepository;
use Kata\Order\Order;
use Kata\Order\OrderId;
use Kata\Warehouse\Reactor\ShipOrderReactor;
use League\Tactician\CommandBus;

class OrderRepository extends EventSourcedAggregateRootRepository
{
    public function __construct(
        MessageDispatcher $dispatcher = null,
        MessageDecorator $decorator = null,
        ClassNameInflector $classNameInflector = null
    ) {
        parent::__construct(
            Order::class,
            resolve(IlluminateUuidV4MessageRepository::class, [
               'tableName' => 'order_events',
                'tableSchema' => new DefaultTableSchema(),
            ]),
            new SynchronousMessageDispatcher(
                resolve(ShipOrderReactor::class),
            ),
            $decorator,
            $classNameInflector
        );
    }

    public function retrieve(AggregateRootId | OrderId $orderId): Order
    {
        return parent::retrieve($orderId);
    }

    public function persist(object $order): void
    {
        if(!$order instanceof Order){
            throw new \Exception("what are you doing?");
        }
        parent::persist($order);
    }
}
