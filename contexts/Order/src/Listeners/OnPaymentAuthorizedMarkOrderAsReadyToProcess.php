<?php

namespace Kata\Order\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Kata\Order\Commands\MarkOrderAsReadyForProcessing;
use Kata\Order\Exceptions\SorryOrderIsAlreadyReadyForProcessing;
use Kata\Payments\Events\PaymentAuthorized;
use League\Tactician\CommandBus;

class OnPaymentAuthorizedMarkOrderAsReadyToProcess implements ShouldQueue
{
    public function __construct(protected CommandBus $commandBus)
    {
    }

    public function handle(PaymentAuthorized $paymentAuthorized): void
    {
        try {
            $this->commandBus->handle(new MarkOrderAsReadyForProcessing($paymentAuthorized->paymentReference->toOrderId()));
        } catch (SorryOrderIsAlreadyReadyForProcessing){
            return;
        }
    }
}
