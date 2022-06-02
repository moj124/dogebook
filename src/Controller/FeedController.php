<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Comment;
use App\Entity\Dog;
use App\Service\DogCRUDService;
use App\Service\CommentCRUDService;
use App\Service\PostCRUDService;
use App\Service\PackService;
use App\Form\PostFormType;
use App\Form\CommentFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FeedController extends AbstractController
{
    public function index(
        DogCRUDService $dogService,
        PostCRUDService $postService,
        CommentCRUDService $commentService, 
        PackService $packService
        ): Response 
    {

        $dogUser = $this->getUser();

        $postAuthor = $dogService->getDogNiceName($dogUser);

        $posts = $dogService->getAllPosts($dogUser);

        if(count($posts) === 0) {
            return $this->redirectToRoute('add_post');
        }
        
        $myPack = $packService->getPack($dogUser);

        $postsPack = $postService->getAllMyPackPosts($myPack);
        
        array_push($postsPack, $posts);

        $comments = $commentService->getAllCommentsByPosts($posts);

        $dogs = $dogService->getAllDogs();

        $otherDogUsers = $dogService->getDogsNotInPack($myPack, $dogs);

        return $this->render(
            'feed/feed.html.twig', 
            [
                'posts' => $posts,
                'currentDogUserNiceName' => $postAuthor,
                'currentDogUser' => $dogUser,
                'comments' => $comments,
                'dogUsers' => $otherDogUsers,
                'myPack' => $myPack
            ]
        );
    }

    public function addFriend(PackService $packService, Dog $dog): Response
    {
        $dogUser = $this->getUser();
        $packService->addDogToPack($dogUser, $dog);
        return $this->redirectToRoute('feed');
    }

    public function removeFriend(PackService $packService, Dog $dog): Response
    {
        return $this->redirectToRoute('feed');
    }

    public function createComment(Request $request, CommentCRUDService $commentService ,Post $post) : Response
    {
        $comment = new Comment();

        $form = $this->createForm(CommentFormType::class, $comment);
        
        $dogUser = $this->getUser();

        $form->handleRequest($request);
        
        if($commentService->handleAddComment($comment, $post, $dogUser, $form)) {
            return $this->redirectToRoute('feed');
        }

        // Rendering the view if the form has not been submitted
        return $this->render(
            'feed/comment/add-comment.html.twig', 
            [
                'form' => $form->createView(),
            ]
        );
    }

    public function createPost(Request $request, DogCRUDService $dogService): Response 
    {
        $post = new Post();

        $form = $this->createForm(PostFormType::class, $post);

        $dogUser = $this->getUser();
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $dogService->savePostForDog($dogUser, $post);
            return $this->redirectToRoute('feed');
        }

        // Rendering the view if the form has not been submitted
        return $this->render(
            'feed/post/add-post.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
