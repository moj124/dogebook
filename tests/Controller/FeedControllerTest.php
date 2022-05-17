<?php

namespace App\Tests\Controller;

use App\Entity\Post;
use App\Entity\Dog;
use App\Repository\DogRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FeedControllerTest extends WebTestCase
{
    public function testItSubmitAndCreatePost(): void
    {
        $client = static::createClient();
        $dogRepo = static::getContainer()->get(DogRepository::class);
        
        $testUser = $dogRepo->findOneByUsername('testUser');
        
        $client->loginUser($testUser);

        $crawler = $client->request('GET','/add-post');
        // var_dump($client->getResponse()->getContent());
        
        $form = $crawler->selectButton('Save')->form();
        $form["post_form[post_text]"] = "testing post";
        
        $crawler = $client->submit($form);
        
        $postRepo = static::getContainer()->get(PostRepository::class);
        $newPost = $postRepo->findBy(['post_text' => 'testing post'])[0];
        $this->assertTrue($newPost->getPostText() === 'testing post');
        $client->followRedirects(true);
    }
}
