<?php

namespace Kata\Warehouse\CommandHandlers;

use Kata\Warehouse\Commands\ReserveItems;
use Kata\Warehouse\DefaultAggregateRootId;
use Kata\Warehouse\Exceptions\SorryCannotDecreaseStock;
use Kata\Warehouse\Infra\InventoryRepository;
use Kata\Warehouse\Infra\OrderShipmentRepository;
use Ramsey\Uuid\Uuid;

class ReserveItemsHandler
{

    public function __construct(
        protected InventoryRepository $inventoryRepository,
    )
    {
    }

    public function handle(ReserveItems $reserveItems)
    {
        $defaultItem = 'e561fad8-33fa-4407-b250-01f5eaa23fcd';

        $inventory = $this->inventoryRepository->retrieve(DefaultAggregateRootId::fromString($defaultItem));
        $inventory->decreaseStock($reserveItems->itemCount);
        $this->inventoryRepository->persist($inventory);
    }
}
