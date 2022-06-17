<?php

namespace Kata\Warehouse\Events;

use EventSauce\EventSourcing\Serialization\SerializablePayload;
use Kata\Order\OrderId;

class OrderShouldBeShipped implements SerializablePayload
{

    public function __construct(
        public readonly \Kata\Order\OrderId $orderId,
        public readonly int $itemCount = 1,
    )
    {
    }

    public function toPayload(): array
    {
        return [
            'orderId' => $this->orderId->toString(),
            'itemCount' => $this->itemCount,
        ];
    }

    public static function fromPayload(array $payload): static
    {
        return new self(
            new OrderId($payload['orderId']),
            $payload['itemCount']
        );
    }
}
