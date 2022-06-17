<?php

namespace Kata\Warehouse\Events;

use EventSauce\EventSourcing\Serialization\SerializablePayload;

class StockDecreased implements SerializablePayload
{

    public function __construct(public readonly int $quantity)
    {
    }

    public function toPayload(): array
    {
        return [
            'quantity' => $this->quantity
        ];
    }

    public static function fromPayload(array $payload): static
    {
        return new self($payload['quantity']);
    }
}
