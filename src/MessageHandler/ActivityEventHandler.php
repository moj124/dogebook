<?php

namespace App\MessageHandler;

use App\Message\BaseEvent;
use Lagdo\Symfony\Facades\Log;
use App\Repository\NotificationRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ActivityEventHandler implements MessageHandlerInterface
{
    private NotificationRepository $notRepo;

    public function __construct(NotificationRepository $repo)
    {
        $this->notRepo = $repo;
    }

    public function __invoke(BaseEvent $event)
    {
        Log::info('NotificationEventHandler@__invoke event processed', [
            'event_type' => $event->getType(),
            'dog_id' => $event->getDog()->getId(),
        ]);

        $event->handle($this->notRepo);
    }
}
