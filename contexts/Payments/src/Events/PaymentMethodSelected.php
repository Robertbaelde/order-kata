<?php

namespace Kata\Payments\Events;

use Kata\Payments\PaymentMethod;
use Kata\Payments\PaymentReference;

class PaymentMethodSelected
{
    public function __construct(
        public readonly PaymentReference $paymentReference,
        public readonly PaymentMethod $paymentMethod)
    {
    }
}
