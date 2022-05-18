<?php

namespace App\MessageHandler;

use App\Message\BaseEvent;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class ActivityEventHandler implements MessageHandlerInterface
{
    public function __invoke(BaseEvent $event)
    {
        // Create notification
        // assign type and content to it
        // persist it
        // test using this https://github.com/zenstruck/messenger-test
    }
}
