<?php

namespace App\Tests\Controller;

use App\Entity\Post;
use App\Entity\Dog;
use App\Service\DogCRUDService;
use App\Service\PostCRUDService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FeedControllerTest extends WebTestCase
{
    public function testPostCanBeCreated(): void
    {
        self::bootKernel();

        $dogRepo = static::getContainer()->get(DogCRUDService::class);
        $dog = new Dog();
        $dog->setUserName('admin');
        $dog->setPassword('password123');
        $dogRepo->saveDog($dog);

        

        $post = new Post();


        $post->setDogId($dog->getId());
        $post->setPostText("Woof Woof");
        $post->setCreatedAt(new \DateTimeImmutable());

        $postRepo->savePost($post);
        echo($dog);
        // $this->assertTrue($newDog->getUserIdentifier() === 'test123');
        // $client->followRedirects(true);
    }
}
