<?php

namespace App\Message;

use App\Entity\Dog;

abstract class BaseEvent
{
    protected Dog $dog;
    protected string $type;
    protected string $content;

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

    abstract function handle(): void;
}
