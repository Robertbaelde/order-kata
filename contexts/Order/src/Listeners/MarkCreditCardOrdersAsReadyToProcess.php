<?php

namespace Kata\Order\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Kata\Order\Commands\MarkOrderAsReadyForProcessing;
use Kata\Payments\Events\PaymentMethodSelected;
use Kata\Payments\PaymentMethod;
use League\Tactician\CommandBus;

class MarkCreditCardOrdersAsReadyToProcess implements ShouldQueue
{
    public function __construct(protected CommandBus $commandBus)
    {

    }

    public function handle(PaymentMethodSelected $paymentMethodSelected)
    {
        if ($paymentMethodSelected->paymentMethod === PaymentMethod::CreditCard) {
            $this->commandBus->handle(new MarkOrderAsReadyForProcessing($paymentMethodSelected->paymentReference->toOrderId()));
        }
    }
}
