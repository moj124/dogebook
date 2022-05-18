<?php 

namespace App\Message\ActivityEvents;

use App\Entity\Dog;
use App\Entity\Post;
use App\Message\BaseEvent;
use App\Domain\ActivityTypeEnum;

final class CreatePostEvent extends BaseEvent
{
    public function __construct(Dog $dog, Post $post)
    {
        $this->dog = $dog;
        $this->content = ActivityTypeEnum::CREATE_POST;
        $this->type = 
            "{$dog->getUserIdentifier} created a post with the body {$post->getPostText}";
    }
}