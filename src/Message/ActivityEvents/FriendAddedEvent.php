<?php

namespace App\Message\ActivityEvents;

use App\Entity\Dog;
use App\Message\BaseEvent;
use App\Entity\Notification;
use App\Domain\ActivityTypeEnum;
use App\Repository\NotificationRepository;

class FriendAddedEvent extends BaseEvent
{
    public function __construct(Dog $dog1, Dog $dog2)
    {
        $this->dog = $dog1;
        $this->type = ActivityTypeEnum::FRIEND_ADDED()->getValue();
        $this->content =
            "{$dog1->getUserIdentifier()} added {$dog2->getUserIdentifier()} to their pack.";
    }

    public function handle(NotificationRepository $notificationRepository): void
    {
        $notification = (new Notification())
            ->setDog($this->dog)
            ->setType($this->type)
            ->setContent($this->content);

        $notificationRepository->add($notification, true);
    }
}