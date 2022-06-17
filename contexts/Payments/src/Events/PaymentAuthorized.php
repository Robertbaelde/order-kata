<?php

namespace Kata\Payments\Events;

use Kata\Payments\PaymentReference;

class PaymentAuthorized
{

    public function __construct(public readonly PaymentReference $paymentReference)
    {
    }
}
