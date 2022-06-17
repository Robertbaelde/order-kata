<?php

namespace Kata\Order\Providers;

use EventSauce\EventSourcing\DefaultHeadersDecorator;
use EventSauce\EventSourcing\MessageDecorator;
use EventSauce\EventSourcing\Serialization\ConstructingMessageSerializer;
use EventSauce\EventSourcing\Serialization\MessageSerializer;
use EventSauce\UuidEncoding\StringUuidEncoder;
use EventSauce\UuidEncoding\UuidEncoder;
use Illuminate\Support\ServiceProvider;
use Kata\Order\CommandHandlers\MarkOrderAsReadyForProcessingHandler;
use Kata\Order\CommandHandlers\PlaceOrderHandler;
use Kata\Order\Commands\MarkOrderAsReadyForProcessing;
use Kata\Order\Commands\PlaceOrder;
use League\Tactician\Handler\Locator\InMemoryLocator;

class OrderServiceProvider extends ServiceProvider
{
    public function register()
    {
        // should move this to eventsauce service provider
        $this->app->bind(UuidEncoder::class, StringUuidEncoder::class);

        $this->app->bind(MessageSerializer::class, function ($app) {
            return $app->make(ConstructingMessageSerializer::class);
        });

        $this->app->bind(MessageDecorator::class, function ($app) {
            return $app->make(DefaultHeadersDecorator::class, ['timeOfRecordingFormat' => 'Y-m-d H:i:s']);
        });

        $this->app->register(OrderEventServiceProvider::class);

        $locator = $this->app->make(InMemoryLocator::class);
        $locator->addHandler($this->app->make(PlaceOrderHandler::class), PlaceOrder::class);
        $locator->addHandler($this->app->make(MarkOrderAsReadyForProcessingHandler::class), MarkOrderAsReadyForProcessing::class);
    }
}
