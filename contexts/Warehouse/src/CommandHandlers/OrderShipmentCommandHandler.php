<?php

namespace Kata\Warehouse\CommandHandlers;

use Kata\Warehouse\Infra\OrderShipmentRepository;

class OrderShipmentCommandHandler
{
    public function __construct(
        protected OrderShipmentRepository $orderShipmentRepository
    )
    {
    }

    public function handle($command)
    {
        if(!isset($command->orderId)){
            throw new \Exception("command must have a order Id in order to be processed by shipment");
        }

        $orderShipment = $this->orderShipmentRepository->retrieve($command->orderId);
        $orderShipment->handle($command);
        $this->orderShipmentRepository->persist($orderShipment);
    }
}
