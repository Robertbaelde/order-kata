<?php

namespace Kata\Payments\Commands;

use Kata\Payments\PaymentMethod;
use Kata\Payments\PaymentReference;

class SelectPaymentMethod
{
     public function __construct(
         public readonly PaymentReference $paymentReference,
         public readonly PaymentMethod $paymentMethod,
     )
     {
     }
}
