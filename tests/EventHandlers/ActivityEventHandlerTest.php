<?php

namespace App\Tests\EventHandlers;

use App\Repository\DogRepository;
use App\Repository\PostRepository;
use App\Message\ActivityEvents\CreatePostEvent;
use App\MessageHandler\ActivityEventHandler;
use Symfony\Component\Messenger\MessageBusInterface;
use Zenstruck\Messenger\Test\InteractsWithMessenger;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Messenger\MessageBus;

class ActivityEventHandlerTest extends KernelTestCase
{
    use InteractsWithMessenger;

    private MessageBus $bus;

    public function setUp(): void
    {
        $this->bus= new MessageBus();
    }

    public function testItCanDispatchCreatePostMessages()
    {
        self::bootKernel();
        $dog = (static::getContainer()->get(DogRepository::class))->findOneBy(['username' => 'testUser']);
        $post = (static::getContainer()->get(PostRepository::class))->find(2);

        $this->bus->dispatch(new CreatePostEvent($dog, $post));

        $this->messenger('sync')->queue()->assertCount(1);
    }
}
