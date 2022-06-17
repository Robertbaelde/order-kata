<?php

namespace Kata\PurchaseOrder\Exceptions;

class SorryCouldNotPlacePurchaseOrder extends \Exception
{

    public static function customerIsNotTrusted()
    {
        return new self('customer is not trusted');
    }
}
