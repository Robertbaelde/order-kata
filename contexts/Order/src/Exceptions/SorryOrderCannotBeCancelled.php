<?php

namespace Kata\Order\Exceptions;

class SorryOrderCannotBeCancelled extends \Exception
{

    public static function orderHasAlreadyBeenShipped(): self
    {
        return new self('Sorry order cannot be cancelled, order has already been shipped');
    }
}
