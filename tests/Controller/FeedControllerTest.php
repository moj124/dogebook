<?php

namespace App\Tests\Controller;

use App\DataFixtures\PostFixture;
use App\Entity\Post;
use App\Entity\Dog;
use App\Repository\DogRepository;
use App\Repository\PostRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FeedControllerTest extends WebTestCase
{
    public function testItSubmitAndCreatePost(): void
    {
        $client = static::createClient();
        $dogRepo = static::getContainer()->get(DogRepository::class);
        $postRepo = static::getContainer()->get(PostRepository::class);
        $testUser = $dogRepo->findOneByUsername('testUser');
        $client->loginUser($testUser);

        $crawler = $client->request('GET','/add-post');
        $form = $crawler->selectButton('Save')->form();
        $form["post_form[post_text]"] = "testing post";
        $crawler = $client->submit($form);
        
        $newPost = $postRepo->findBy(['post_text' => 'testing post'])[0];
        $this->assertTrue($newPost->getPostText() === 'testing post');
        $client->followRedirects(true);
    }
}
