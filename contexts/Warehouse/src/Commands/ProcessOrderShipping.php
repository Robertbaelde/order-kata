<?php

namespace Kata\Warehouse\Commands;

use Kata\Order\OrderId;

class ProcessOrderShipping
{
    public function __construct(
        public readonly OrderId $orderId,
        public readonly int $itemCount,
    )
    {
    }
}
