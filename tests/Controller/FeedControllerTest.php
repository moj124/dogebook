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
    private $client;
    private $dogRepo;
    private $postRepo;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->dogRepo = static::getContainer()->get(DogRepository::class);
        $this->postRepo = static::getContainer()->get(PostRepository::class);

    }

    public function testSubmitAndCreatePost(): void
    {
        $testUser = $this->dogRepo->findOneByUsername('testUser');
        $this->client->loginUser($testUser);

        $crawler = $this->client->request('GET','/add-post');
        $form = $crawler->selectButton('Save')->form();
        $form["post_form[post_text]"] = "testing post";
        $crawler = $this->client->submit($form);
        
        $newPost = $this->postRepo->findBy(['post_text' => 'testing post'])[0];
        $this->assertTrue($newPost->getPostText() === 'testing post');
    }

    public function testItCanEditAnExistingPost(): void
    {
        $testUser = $this->dogRepo->findOneByUsername('testUser');
        $this->client->loginUser($testUser);

        // We will need to find a new form here to do the edit
        // Posts exist for the testUser already and their content is set. Just need to update it
        // Should assert that the db was updated
    }

    public function testItCanDeleteAPost(): void
    {
        // Should be able to log in as a user and delete a post by id
    }
}
