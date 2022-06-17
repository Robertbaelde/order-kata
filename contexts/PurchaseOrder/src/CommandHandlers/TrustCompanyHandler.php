<?php

namespace Kata\PurchaseOrder\CommandHandlers;

use Kata\PurchaseOrder\Commands\TrustCompany;
use Kata\PurchaseOrder\TrustedCompanies;

class TrustCompanyHandler
{
    public function handle(TrustCompany $trustCompany)
    {
        if(!TrustedCompanies::find($trustCompany->companyId)){
            TrustedCompanies::create(['company_id' => $trustCompany->companyId]);
        }
    }
}
