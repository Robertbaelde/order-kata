<?php

namespace Kata\PurchaseOrder\Commands;

use Kata\Order\OrderId;

class PlacePurchaseOrder
{
    public function __construct(
        public readonly OrderId $orderId,
        public readonly string $companyId,
    )
    {
    }
}
