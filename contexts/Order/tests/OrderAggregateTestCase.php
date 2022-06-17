<?php

namespace Kata\Order\Tests;

use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\TestUtilities\AggregateRootTestCase;
use Kata\Order\Order;
use Kata\Order\OrderId;

class OrderAggregateTestCase extends AggregateRootTestCase
{

    protected function newAggregateRootId(): AggregateRootId
    {
        return OrderId::new();
    }

    protected function aggregateRootClassName(): string
    {
        return Order::class;
    }

    public function handle(\Closure $closure)
    {
        /** @var Order $aggregate */
        $aggregate = $this->repository->retrieve($this->aggregateRootId);
        $closure($aggregate);
        $this->repository->persist($aggregate);
    }
}
