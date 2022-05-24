<?php 

namespace App\Message\ActivityEvents;

use App\Entity\Dog;
use App\Entity\Post;
use App\Message\BaseEvent;
use App\Entity\Notification;
use App\Domain\ActivityTypeEnum;
use App\Repository\NotificationRepository;

final class CreatePostEvent extends BaseEvent
{
    public function __construct(Dog $dog, Post $post)
    {
        $this->dog = $dog;
        $this->type = ActivityTypeEnum::CREATE_POST()->getValue();
        $this->content =
            "{$dog->getUserIdentifier()} created a post with the body {$post->getPostText()}";
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