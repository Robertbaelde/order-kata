<?php

namespace Kata\Payments\Commands;

use Kata\Payments\PaymentReference;

class AuthorizePayment
{
    public function __construct(
        public readonly PaymentReference $paymentReference
    )
    {
    }
}
