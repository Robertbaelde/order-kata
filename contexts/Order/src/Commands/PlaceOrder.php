<?php

namespace Kata\Order\Commands;

use Kata\Order\OrderId;

class PlaceOrder
{
    public function __construct(
        public readonly OrderId $orderId
    )
    {
    }
}
