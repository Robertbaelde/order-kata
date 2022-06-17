<?php

namespace Kata\Warehouse\Commands;

use Kata\Order\OrderId;

class PlaceOrderOnBacklog
{

    public function __construct(
        public readonly OrderId $orderId,
        public readonly string $reason
    ) {
    }
}
