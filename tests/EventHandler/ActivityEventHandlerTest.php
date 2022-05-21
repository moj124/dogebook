<?php

namespace App\Tests\EventHandlers;

use App\Message\BaseEvent;
use App\Repository\DogRepository;
use App\Repository\PostRepository;
use Symfony\Component\Messenger\Envelope;
use App\Message\ActivityEvents\CreatePostEvent;
use Zenstruck\Messenger\Test\InteractsWithMessenger;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ActivityEventHandlerTest extends KernelTestCase
{
    use InteractsWithMessenger;

    private DogRepository $dogRepo;
    private PostRepository $postRepo;

    public function setUp(): void
    {
        self::bootKernel();
        $this->dogRepo = static::getContainer()->get(DogRepository::class);
        $this->postRepo = static::getContainer()->get(PostRepository::class);
    }

    public function testItCanDispatchCreatePostMessages(): void
    {
        $dog = $this->dogRepo->findOneBy(['username' => 'testUser']);
        $post = $this->postRepo->find(2);

        $event = new CreatePostEvent($dog, $post);

        $this->dispatchEventForTest($event);
        $dispatched =  $this->messenger()->dispatched();

        $dispatched->assertContains(CreatePostEvent::class, 1);
    }

    public function testItCanDispatchAddFriendMessages(): void
    {
        
    }

    private function dispatchEventForTest(BaseEvent $event): void
    {
        $this->messenger()->send(Envelope::wrap($event));
    }
}
