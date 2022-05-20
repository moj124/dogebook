<?php 

namespace App\Message\ActivityEvents;

use App\Domain\ActivityTypeEnum;
use App\Entity\Dog;
use App\Entity\Post;
use App\Message\BaseEvent;

final class CreatePostEvent extends BaseEvent
{
    public function __construct(Dog $dog, Post $post)
    {
        $this->dog = $dog;
        $this->type = ActivityTypeEnum::CREATE_POST()->getValue();
        $this->content =
            "{$dog->getUserIdentifier()} created a post with the body {$post->getPostText()}";
    }

    public function handle(): void
    {
        // create notification of type
        // save it
        var_dump($this->type, $this->content);
    }
}