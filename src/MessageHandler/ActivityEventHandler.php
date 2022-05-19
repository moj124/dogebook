<?php

namespace App\MessageHandler;

use App\Message\BaseEvent;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class ActivityEventHandler implements MessageHandlerInterface
{
    public function __invoke(BaseEvent $event)
    {
        $event->handle();
    }
}
