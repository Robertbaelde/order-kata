<?php

namespace Kata\Warehouse\Events;

use EventSauce\EventSourcing\Serialization\SerializablePayload;

class OrderPlacedOnBacklog implements SerializablePayload
{

    public function __construct(public readonly string $reason)
    {
    }

    public function toPayload(): array
    {
        return [
            'reason' => $this->reason
        ];
    }

    public static function fromPayload(array $payload): static
    {
        return new self($payload['reason']);
    }
}
