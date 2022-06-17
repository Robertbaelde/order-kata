<?php

namespace Kata\Payments\CommandHandlers;

use Illuminate\Contracts\Events\Dispatcher;
use Kata\Payments\Commands\AuthorizePayment;
use Kata\Payments\Events\PaymentAuthorized;
use Kata\Payments\Payment;

class AuthorizePaymentHandler
{
    public function __construct(
        protected Dispatcher $dispatcher
    )
    {
    }

    public function handle(AuthorizePayment $authorizePayment)
    {
        $payment = Payment::findOrFail($authorizePayment->paymentReference->toString());
        if($payment->authorized_at !== null){
            throw new \Exception("payment already authorized");
        }

        $payment->update(['authorized_at' => now()]);

        $this->dispatcher->dispatch(new PaymentAuthorized($authorizePayment->paymentReference));
    }
}
