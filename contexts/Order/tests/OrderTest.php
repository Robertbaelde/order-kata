<?php

namespace Kata\Order\Tests;

use Kata\Order\Events\OrderCancelled;
use Kata\Order\Events\OrderMarkedAsReadyForProcessing;
use Kata\Order\Events\OrderPlaced;
use Kata\Order\Events\OrderShipped;
use Kata\Order\Exceptions\SorryOrderCannotBeCancelled;
use Kata\Order\Exceptions\SorryOrderIsAlreadyReadyForProcessing;
use Kata\Order\Order;

class OrderTest extends OrderAggregateTestCase
{
    /** @test */
    public function an_order_can_be_placed()
    {
        $this->given()
            ->when(fn(Order $order) => $order->place())
            ->then(
                new OrderPlaced()
            );
    }

    /** @test */
    public function a_order_can_be_marked_as_ready_to_process()
    {
        $this
            ->given(
                new OrderPlaced()
            )
            ->when(fn(Order $order) => $order->readyForProcessing())
            ->then(
                new OrderMarkedAsReadyForProcessing()
            );
    }

    /** @test */
    public function a_order_can_only_be_marked_as_ready_to_be_processed_once()
    {
        $this
            ->given(
                new OrderPlaced(),
                new OrderMarkedAsReadyForProcessing(),
            )
            ->when(fn(Order $order) => $order->readyForProcessing())
            ->expectToFail(
                new SorryOrderIsAlreadyReadyForProcessing(),
            );
    }

    /** @test */
    public function a_order_can_be_marked_as_shipped()
    {
        $this
            ->given(
                new OrderPlaced(),
                new OrderMarkedAsReadyForProcessing()
            )
            ->when(fn(Order $order) => $order->shipped())
            ->then(
                new OrderShipped()
            );
    }

    /** @test */
    public function a_order_can_be_cancelled()
    {
        $this
            ->given(
                new OrderPlaced()
            )
            ->when(fn(Order $order) => $order->cancel())
            ->then(
                new OrderCancelled()
            );
    }

    /** @test */
    public function once_a_order_is_shipped_it_cannot_be_cancelled_anymore()
    {
        $this
            ->given(
                new OrderPlaced(),
                new OrderShipped(),
            )
            ->when(fn(Order $order) => $order->cancel())
            ->expectToFail(
                SorryOrderCannotBeCancelled::orderHasAlreadyBeenShipped()
            );
    }


}
