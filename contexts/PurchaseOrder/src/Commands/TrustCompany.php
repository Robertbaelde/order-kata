<?php

namespace Kata\PurchaseOrder\Commands;

class TrustCompany
{
    public function __construct(
        public readonly string $companyId
    )
    {
    }
}
