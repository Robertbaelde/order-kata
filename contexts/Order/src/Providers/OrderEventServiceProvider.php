<?php

namespace Kata\Order\Providers;

use App\Providers\EventServiceProvider;
use Kata\Order\Listeners\MarkCreditCardOrdersAsReadyToProcess;
use Kata\Order\Listeners\OnPaymentAuthorizedMarkOrderAsReadyToProcess;
use Kata\Payments\Events\PaymentAuthorized;
use Kata\Payments\Events\PaymentMethodSelected;

class OrderEventServiceProvider extends EventServiceProvider
{
    protected $listen = [
        PaymentMethodSelected::class => [MarkCreditCardOrdersAsReadyToProcess::class],
        PaymentAuthorized::class => [OnPaymentAuthorizedMarkOrderAsReadyToProcess::class],
    ];
}
