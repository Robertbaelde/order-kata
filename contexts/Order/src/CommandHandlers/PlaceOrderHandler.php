<?php

namespace Kata\Order\CommandHandlers;

use Kata\Order\Commands\PlaceOrder;
use Kata\Order\Infra\OrderRepository;

class PlaceOrderHandler
{
    public function __construct(
        protected OrderRepository $orderRepository
    )
    {
    }

    public function handle(PlaceOrder $placeOrder)
    {
        $order = $this->orderRepository->retrieve($placeOrder->orderId);
        $order->place();
        $this->orderRepository->persist($order);
    }
}
