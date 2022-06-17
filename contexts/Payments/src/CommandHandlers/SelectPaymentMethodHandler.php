<?php

namespace Kata\Payments\CommandHandlers;

use Illuminate\Contracts\Events\Dispatcher;
use Kata\Payments\Commands\SelectPaymentMethod;
use Kata\Payments\Events\PaymentMethodSelected;
use Kata\Payments\Exceptions\CannotChangePaymentSelection;
use Kata\Payments\Payment;
use Kata\Payments\PaymentMethod;

class SelectPaymentMethodHandler
{

    public function __construct(
        protected Dispatcher $dispatcher
    )
    {
    }

    public function handle(SelectPaymentMethod $selectPaymentMethod): void
    {
        $payment = Payment::query()->find($selectPaymentMethod->paymentReference->toString());
        if($payment){
            throw new CannotChangePaymentSelection;
        }

        Payment::create([
            'reference' => $selectPaymentMethod->paymentReference->toString(),
            'method' => $selectPaymentMethod->paymentMethod,
        ]);

        $this->dispatcher->dispatch(new PaymentMethodSelected($selectPaymentMethod->paymentReference, $selectPaymentMethod->paymentMethod));
    }
}
