<?php

namespace App\Providers;


use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use League\Tactician\CommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\Locator\HandlerLocator;
use League\Tactician\Handler\Locator\InMemoryLocator;
use League\Tactician\Handler\MethodNameInflector\HandleClassNameInflector;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;

class CommandBusProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(InMemoryLocator::class, function (Application $application){
            return new InMemoryLocator();
        });

        $this->app->bind(CommandBus::class, function (Application $application){
            $inflector = new HandleInflector();

            // Choose our locator and register our command
//            $locator = $this->a InMemoryLocator();
//            $locator->addHandler(new RentMovieHandler(), RentMovieCommand::class);

            // Choose our Handler naming strategy
            $nameExtractor = new ClassNameExtractor();

            // Create the middleware that executes commands with Handlers
            $commandHandlerMiddleware = new CommandHandlerMiddleware($nameExtractor, $application->make(InMemoryLocator::class), $inflector);

            // Create the command bus, with a list of middleware
            return new CommandBus([$commandHandlerMiddleware]);
        });
    }
}
