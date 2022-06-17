<?php

namespace Kata\Order;

use EventSauce\EventSourcing\AggregateRootId;
use Ramsey\Uuid\Uuid;

class OrderId implements AggregateRootId
{
    public function __construct(public readonly string $id)
    {
    }

    public static function new(): static
    {
        return new static(Uuid::uuid4()->toString());
    }

    public function toString(): string
    {
        return $this->id;
    }

    public static function fromString(string $aggregateRootId): static
    {
        return new static($aggregateRootId);
    }
}
