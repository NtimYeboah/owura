<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Bref\Context\Context;
use Bref\Event\EventBridge\EventBridgeEvent;
use Bref\Event\EventBridge\EventBridgeHandler;

class EventHandler extends EventBridgeHandler
{
    public function handleEventBridge(EventBridgeEvent $event, Context $context): void
    {
        print_r(json_encode($event->getDetail()));
    }
}

return new EventHandler();
