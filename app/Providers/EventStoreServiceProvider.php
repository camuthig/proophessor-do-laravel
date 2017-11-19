<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Contracts\Foundation\Application;
use Prooph\EventStoreBusBridge\EventPublisher;
use Prooph\ServiceBus\EventBus;

class EventStoreServiceProvider extends \Camuthig\EventStore\Package\EventStoreServiceProvider
{
    public function register(): void
    {
        parent::register();

        $this->app->singleton('event_store_bus_bridge.todo_event_publisher', function (Application $app) {
            $defaultEventBus = $app->make(EventBus::class);

            return new EventPublisher($defaultEventBus);
        });
    }
}
