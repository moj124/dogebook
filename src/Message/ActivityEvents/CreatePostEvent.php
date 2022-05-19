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
        $this->type = "test";
        $this->content =
            "{$dog->getUserIdentifier()} created a post with the body {$post->getPostText()}";
    }

    public function handle(): void
    {
        var_dump($this->content);
    }
}