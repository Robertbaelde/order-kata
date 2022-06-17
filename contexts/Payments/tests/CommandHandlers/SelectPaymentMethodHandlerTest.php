<?php

namespace Kata\Payments\Tests\CommandHandlers;


use Illuminate\Events\Dispatcher;
use Illuminate\Events\NullDispatcher;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Testing\Fakes\EventFake;
use Kata\Payments\CommandHandlers\SelectPaymentMethodHandler;
use Kata\Payments\Commands\SelectPaymentMethod;
use Kata\Payments\Events\PaymentMethodSelected;
use Kata\Payments\Exceptions\CannotChangePaymentSelection;
use Kata\Payments\Payment;
use Kata\Payments\PaymentMethod;
use Kata\Payments\PaymentReference;
use Ramsey\Uuid\Uuid;

class SelectPaymentMethodHandlerTest extends \Tests\TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_payment_method_can_be_selected_for_a_order()
    {
        $fakeDispatcher = new EventFake(new NullDispatcher(new Dispatcher()));

        $orderId = Uuid::uuid4()->toString();
        $paymentMethod = PaymentMethod::CreditCard;

        $handler = new SelectPaymentMethodHandler($fakeDispatcher);
        $handler->handle(new SelectPaymentMethod(new PaymentReference($orderId), $paymentMethod));

        $fakeDispatcher->assertDispatched(PaymentMethodSelected::class, function (PaymentMethodSelected $paymentMethodSelected) use ($orderId, $paymentMethod) {
            $this->assertEquals($orderId, $paymentMethodSelected->paymentReference->toString());
            $this->assertEquals($paymentMethod, $paymentMethodSelected->paymentMethod);
            return true;
        });

        $payment = Payment::first();
        $this->assertEquals($orderId, $payment->reference);
        $this->assertEquals($paymentMethod, $payment->method);
    }

    /** @test */
    public function a_payment_method_cannot_be_changed()
    {
        $fakeDispatcher = new EventFake(new NullDispatcher(new Dispatcher()));

        $orderId = Uuid::uuid4()->toString();
        $paymentMethod = PaymentMethod::CreditCard;

        $handler = new SelectPaymentMethodHandler($fakeDispatcher);
        $handler->handle(new SelectPaymentMethod(new PaymentReference($orderId), $paymentMethod));

        $this->expectException(CannotChangePaymentSelection::class);
        $handler->handle(new SelectPaymentMethod(new PaymentReference($orderId), $paymentMethod));
    }
}
