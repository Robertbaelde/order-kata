<?php

namespace Kata\Order\Commands;

use Kata\Order\OrderId;

class MarkOrderAsReadyForProcessing
{
    public function __construct(
        public readonly OrderId $orderId
    )
    {
    }
}
