<?php

namespace Kata\Warehouse;

use EventSauce\EventSourcing\AggregateAppliesKnownEvents;
use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;
use Kata\Warehouse\Events\StockDecreased;
use Kata\Warehouse\Events\StockIncremented;
use Kata\Warehouse\Exceptions\SorryCannotDecreaseStock;

class ItemInventory implements AggregateRoot
{
    use AggregateRootBehaviour;

    private int $stockCount = 0;

    public function incrementStock(int $quantity): void
    {
        $this->recordThat(new StockIncremented($quantity));
    }

    public function decreaseStock(int $quantity): void
    {
        if(($this->stockCount - $quantity) < 0){
            throw SorryCannotDecreaseStock::requestedAmountOfItemsCurrentlyNotInStock();
        }
        $this->recordThat(new StockDecreased($quantity));
    }

    protected function applyStockIncremented(StockIncremented $stockIncremented): void
    {
        $this->stockCount += $stockIncremented->quantity;
    }

    protected function applyStockDecreased(StockDecreased $stockDecreased): void
    {
        $this->stockCount -= $stockDecreased->quantity;
    }
}

