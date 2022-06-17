<?php

namespace Kata\Order\Events;

use EventSauce\EventSourcing\Serialization\SerializablePayload;

abstract class EmptyEvent implements SerializablePayload
{
    public function toPayload(): array
    {
        return [];
    }

    public static function fromPayload(array $payload): static
    {
        return new static();
    }
}
