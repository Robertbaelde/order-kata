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
use Kata\Warehouse\ItemInventory;
use Kata\Warehouse\Reactor\ShipOrderReactor;

class InventoryRepository extends EventSourcedAggregateRootRepository
{
    public function __construct(
        MessageDispatcher $dispatcher = null,
        MessageDecorator $decorator = null,
        ClassNameInflector $classNameInflector = null
    ) {
        parent::__construct(
            ItemInventory::class,
            resolve(IlluminateUuidV4MessageRepository::class, [
               'tableName' => 'stock_events',
                'tableSchema' => new DefaultTableSchema(),
            ]),
            new SynchronousMessageDispatcher(
                resolve(ShipOrderReactor::class),
            ),
            $decorator,
            $classNameInflector
        );
    }

    public function retrieve(AggregateRootId $itemId): ItemInventory
    {
        return parent::retrieve($itemId);
    }

    public function persist(object $itemInventory): void
    {
        if(!$itemInventory instanceof ItemInventory){
            throw new \Exception("what are you doing?");
        }
        parent::persist($itemInventory);
    }
}
