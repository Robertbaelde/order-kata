<?php

namespace Kata\Warehouse\Commands;

use Kata\Order\OrderId;

class ShipOrder
{
    public function __construct(
        public readonly OrderId $orderId
    )
    {
    }
}
