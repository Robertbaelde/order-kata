<?php

namespace Kata\Warehouse\Commands;

class MarkOrderAsShipped
{

    public function __construct(public readonly \Kata\Order\OrderId $orderId)
    {
    }
}
