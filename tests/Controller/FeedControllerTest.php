<?php

namespace App\Tests\Controller;

use App\DataFixtures\PostFixture;
use App\Entity\Post;
use App\Entity\Dog;
use App\Repository\DogRepository;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FeedControllerTest extends WebTestCase
{
    private $client;
    private $dogRepo;
    private $commentRepo;
    private $postRepo;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->dogRepo = static::getContainer()->get(DogRepository::class);
        $this->commentRepo = static::getContainer()->get(CommentRepository::class);
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

    public function testSubmitAndCreateComment(): void
    {
        $testUser = $this->dogRepo->findOneByUsername('testUser');
        $this->client->loginUser($testUser);
        $testUserPost = $this->postRepo->findBy(['post_text' => 'Woof woofingtons'])[0];
        $url = "/post/{$testUserPost->getId()}/add-comment";
        $crawler = $this->client->request('GET', $url);
        $form = $crawler->selectButton('Save')->form();
        $form["comment_form[comment_text]"] = 'testing comment';
        $crawler = $this->client->submit($form);
        
        $newComment = $this->commentRepo->findBy(['comment_text' => 'testing comment'])[0];
        $this->assertTrue($newComment->getCommentText() === 'testing comment');
    }

    public function testAddDogToPack(): void
    {
        $testUser = $this->dogRepo->findOneByUsername('testUser');
        $this->client->loginUser($testUser);

        $testUserPack = $this->dogRepo->getDogsPack($testUser);

        $url = "/dog/{$testUser->getId()}/add-friend";
        $this->client->request('GET', $url);
        
        $newTestUserPack = $this->dogRepo->getDogsPack($testUser);
        $this->assertTrue((count($testUserPack) + 1) === count($newTestUserPack));
    }

    // public function testItCanEditAnExistingPost(): void
    // {
    //     $testUser = $this->dogRepo->findOneByUsername('testUser');
    //     $this->client->loginUser($testUser);

    //     // We will need to find a new form here to do the edit
    //     // Posts exist for the testUser already and their content is set. Just need to update it
    //     // Should assert that the db was updated
    // }

    // public function testItCanDeleteAPost(): void
    // {
    //     // Should be able to log in as a user and delete a post by id
    // }

    // public function testItCanDeleteComment(): void
    // {
    //     // Should be able to log in as a user and delete a post by id
    // }

    // public function testItCanRemovePackMember(): void
    // {
    //     // Should be able to log in as a user and delete a post by id
    // }

    // public function testItCanRemoveSelfFromPack(): void
    // {
    //     // Should be able to log in as a user and delete a post by id
    // }

}
