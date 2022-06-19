<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Comment;
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
        
        $myPack = $packService->getPack($dogUser);

        if($myPack){
            $postsPack = $postService->getAllMyPackPosts($myPack);
            array_push($postsPack, $posts);
        }

        if(!$posts) {
            return $this->redirectToRoute('add_post');
        }

        $comments = $commentService->getAllCommentsByPosts($posts);

        $dogs = $dogService->getAllDogs();

        $otherDogUsers = $packService->getDogsNotInPack($dogUser, $myPack, $dogs);
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

    public function removePost(PostCRUDService $postService, Post $post): Response
    {
        $dogUser = $this->getUser();

        if($post->getDog() !== $dogUser) {
            return Response::HTTP_UNPROCESSABLE_ENTITY;
        }

        $postService->removePost($post);
        
        return $this->redirectToRoute('feed');
    }
    
    public function removeComment(CommentCRUDService $commentService, Comment $comment): Response
    {
        $dogUser = $this->getUser();

        if($comment->getDog() !== $dogUser) {
            return Response::HTTP_UNPROCESSABLE_ENTITY;
        }

        $commentService->removeComment($comment);
        
        return $this->redirectToRoute('feed');
    }

    public function createComment(Request $request, CommentCRUDService $commentService, Post $post) : Response
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

    public function createPost(Request $request, PostCRUDService $postService): Response 
    {
        $post = new Post();

        $form = $this->createForm(PostFormType::class, $post);

        $dogUser = $this->getUser();
        $form->handleRequest($request);
        
        if($postService->handleAddPost($post, $dogUser, $form)) {
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

    public function editPost(Request $request, PostCRUDService $postService, Post $post): Response 
    {
        $form = $this->createForm(PostFormType::class, $post);

        $form->handleRequest($request);
        
        if($postService->handleEditPost($post, $form)) {
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

    public function editComment(Request $request, CommentCRUDService $commentService, Comment $comment): Response 
    {
        $form = $this->createForm(CommentFormType::class, $comment);

        $form->handleRequest($request);
        
        if($commentService->handleEditComment($comment, $form)) {
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
