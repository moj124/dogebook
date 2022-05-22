<?php

namespace App\Tests\EventHandlers;

use App\Message\BaseEvent;
use App\Repository\DogRepository;
use App\Repository\PostRepository;
use Symfony\Component\Messenger\Envelope;
use App\Message\ActivityEvents\CreatePostEvent;
use App\MessageHandler\ActivityEventHandler;
use App\Repository\NotificationRepository;
use Zenstruck\Messenger\Test\InteractsWithMessenger;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ActivityEventHandlerTest extends KernelTestCase
{
    use InteractsWithMessenger;

    private DogRepository $dogRepo;
    private PostRepository $postRepo;
    private NotificationRepository $notRepo;

    public function setUp(): void
    {
        self::bootKernel();
        $this->dogRepo = static::getContainer()->get(DogRepository::class);
        $this->postRepo = static::getContainer()->get(PostRepository::class);
        $this->notRepo = static::getContainer()->get(NotificationRepository::class);
    }

    public function testItCanDispatchCreatePostMessages(): void
    {
        $dog = $this->dogRepo->findOneBy(['username' => 'testUser']);
        $post = $this->postRepo->findBy(['dog' => $dog])[0];

        $event = new CreatePostEvent($dog, $post);

        $this->dispatchEventForTest($event);
        $dispatched =  $this->messenger()->dispatched();

        $dispatched->assertContains(CreatePostEvent::class, 1);
    }

    public function testCreatePostEventCreatesNotificiation()
    {
        $dog = $this->dogRepo->findOneBy(['username' => 'testUser']);
        $post = $this->postRepo->findBy(['dog' => $dog])[0];

        $event = new CreatePostEvent($dog, $post);
        $listener = new ActivityEventHandler($this->notRepo);

        $listener->__invoke($event);
        $notification = $this->notRepo->findOneBy(['dog' => $dog->getId()], ['created_at' => 'DESC']);

        $this->assertEquals($dog->getId(), $notification->getDog()->getId());
        $this->assertStringContainsString('testUser', $notification->getContent());
    }

    public function testItCanDispatchAddFriendMessages(): void
    {
        
    }

    private function dispatchEventForTest(BaseEvent $event): void
    {
        $this->messenger()->send(Envelope::wrap($event));
    }
}
