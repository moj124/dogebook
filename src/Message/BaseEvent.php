<?php

namespace App\Message;

use App\Entity\Dog;

abstract class BaseEvent
{
    private Dog $dog;
    private string $type;
    private string $content;

    public function getDog(): Dog
    {
        return $this->dog;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
