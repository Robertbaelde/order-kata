<?php

namespace Kata\Order\CommandHandlers;

use Kata\Order\Commands\MarkOrderAsReadyForProcessing;
use Kata\Order\Infra\OrderRepository;

class MarkOrderAsReadyForProcessingHandler
{
    public function __construct(
        protected OrderRepository $orderRepository
    )
    {
    }

    public function handle(MarkOrderAsReadyForProcessing $command)
    {
        $order = $this->orderRepository->retrieve($command->orderId);
        $order->readyForProcessing();
        $this->orderRepository->persist($order);
    }
}
