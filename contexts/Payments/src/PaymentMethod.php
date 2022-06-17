<?php

namespace Kata\Payments;

enum PaymentMethod: string
{
    case CreditCard = 'CreditCard';
    case Check = 'Check';
    case Invoice = 'Invoice';
}
