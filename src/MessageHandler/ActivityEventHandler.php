<?php

namespace App\MessageHandler;

use App\Message\BaseEvent;
use App\Repository\NotificationRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class ActivityEventHandler implements MessageHandlerInterface
{
    private NotificationRepository $notRepo;

    public function __construct(NotificationRepository $repo)
    {
        $this->notRepo = $repo;
    }

    public function __invoke(BaseEvent $event)
    {

        $event->handle($this->notRepo);
    }
}
