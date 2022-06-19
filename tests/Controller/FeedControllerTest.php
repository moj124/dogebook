<?php

namespace App\Tests\Controller;

use App\DataFixtures\PostFixture;
use App\Entity\Post;
use App\Entity\Dog;
use App\Repository\DogRepository;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
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
        $otherUser = $this->dogRepo->findOneByUsername('testAdmin');
        $this->client->loginUser($testUser);

        $url = "/dog/{$otherUser->getId()}/add-friend";
        $this->client->request('GET', $url);
        
        $newTestUserPack = $this->dogRepo->getDogsPack($testUser);
        $this->assertContains($otherUser, $newTestUserPack, '$otherUser Dog is not contained with the $newTestUserPack Array');
    }

    public function testGetALlThings(): void
    {
        $testUser = $this->dogRepo->findOneByUsername('testUser');
        $this->postRepo->findAllPostsByDogPack([$testUser]);
        $this->assertTrue(true);
    }

    public function testItCanEditAnExistingPost(): void
    {
        $testUser = $this->dogRepo->findOneByUsername('testUser');
        $this->client->loginUser($testUser);

        $testUserPost = $this->postRepo->findBy(['post_text' => 'Woof woofingtons'])[0];

        $url = "/post/{$testUserPost->getId()}/edit-post";
        $crawler = $this->client->request('GET', $url);

        $form = $crawler->selectButton('Save')->form();
        $form["post_form[post_text]"] = 'testing post';
        $crawler = $this->client->submit($form);
        
        $newPost = $this->postRepo->findBy(['post_text' => 'testing post'])[0];
        $this->assertTrue($newPost->getPostText() === 'testing post');
    }

    public function testItCanDeleteAPost(): void
    {
        // Should be able to log in as a user and delete a post by id
        $testUser = $this->dogRepo->findOneByUsername('testUser');
        $this->client->loginUser($testUser);

        $posts = $this->postRepo->findAllPostsByDog($testUser);
        $post = $posts[0];

        $url = "/post/{$post->getId()}/remove-post";
        $this->client->request('GET', $url);

        $this->assertEquals($post->getId(), NULL);
    }

    public function testItCanDeleteComment(): void
    {
        // Should be able to log in as a user and delete a comment by id
        $testUser = $this->dogRepo->findOneByUsername('testUser');
        $this->client->loginUser($testUser);

        $posts = $this->postRepo->findAllPostsByDog($testUser);
        $post = $posts[0];

        $comments = $this->commentRepo->findAllCommentsByPosts([$post]);
        $comment = $comments[0];

        $url = "/comment/{$comment->getId()}/remove-comment";
        $this->client->request('GET', $url);

        $this->assertEquals($comment->getId(), NULL);
    }

    public function testItCanRemovePackMember(): void
    {
        // Should be able to log in as a user and remove a pack member by id
        $testUser = $this->dogRepo->findOneByUsername('testUser');
        $otherUser = $this->dogRepo->findOneByUsername('testUser1');
        $this->client->loginUser($testUser);

        $url = "/dog/{$otherUser->getId()}/remove-friend";
        $this->client->request('GET', $url);
        
        $newTestUserPack = $this->dogRepo->getDogsPack($testUser);

        $this->assertNotContains($otherUser, $newTestUserPack, '$otherUser Dog is contained with the $newTestUserPack Array');
    }

    // public function testItCanRemoveSelfFromPack(): void
    // {
    //     // Should be able to log in as a user and delete a post by id
    // }

}
