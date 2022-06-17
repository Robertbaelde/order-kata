<?php

namespace Kata\Payments;

use Kata\Order\OrderId;

class PaymentReference
{
    public function __construct(public readonly string $reference)
    {
    }

    public static function fromOrderId(OrderId $orderId): self
    {
        return new self($orderId->toString());
    }

    public function toString(): string
    {
        return $this->reference;
    }

    public function toOrderId(): OrderId
    {
        return new OrderId($this->reference);
    }


}
