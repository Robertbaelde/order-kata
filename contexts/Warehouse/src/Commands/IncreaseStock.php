<?php

namespace Kata\Warehouse\Commands;

class IncreaseStock
{
    public function __construct(
        public readonly int $qty
    )
    {
    }
}
