<?php

namespace Kata\Warehouse\Exceptions;

class SorryCannotDecreaseStock extends \Exception
{

    public static function requestedAmountOfItemsCurrentlyNotInStock(): self
    {
        return new self('requested amount of items currently not in stock');
    }
}
