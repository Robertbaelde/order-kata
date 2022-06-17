<?php

namespace Kata\Warehouse\Commands;

class ReserveItems
{

    public function __construct(public readonly int $itemCount)
    {
    }
}
