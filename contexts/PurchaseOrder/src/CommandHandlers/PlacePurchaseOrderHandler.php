<?php

namespace Kata\PurchaseOrder\CommandHandlers;

use Kata\Order\Commands\MarkOrderAsReadyForProcessing;
use Kata\Order\Commands\PlaceOrder;
use Kata\Payments\Commands\SelectPaymentMethod;
use Kata\Payments\PaymentMethod;
use Kata\Payments\PaymentReference;
use Kata\PurchaseOrder\Commands\PlacePurchaseOrder;
use Kata\PurchaseOrder\Exceptions\SorryCouldNotPlacePurchaseOrder;
use Kata\PurchaseOrder\PurchaseOrder;
use Kata\PurchaseOrder\TrustedCompanies;
use League\Tactician\CommandBus;

class PlacePurchaseOrderHandler
{
    public function __construct(
        protected CommandBus $commandBus
    )
    {
    }

    public function handle(PlacePurchaseOrder $placePurchaseOrder)
    {
        $company = TrustedCompanies::find($placePurchaseOrder->companyId);
        if(!$company){
            throw SorryCouldNotPlacePurchaseOrder::customerIsNotTrusted();
        }
        PurchaseOrder::create(['order_id' => $placePurchaseOrder->orderId->toString(), 'company_id' => $placePurchaseOrder->companyId]);

        // should maybe be in order domain?
        $this->commandBus->handle(new PlaceOrder($placePurchaseOrder->orderId));
        $this->commandBus->handle(new MarkOrderAsReadyForProcessing($placePurchaseOrder->orderId));
        $this->commandBus->handle(new SelectPaymentMethod(PaymentReference::fromOrderId($placePurchaseOrder->orderId), PaymentMethod::Invoice));
    }
}
