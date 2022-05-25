<?php

namespace App\Controller;

use App\Entity\Post;

use App\Entity\Comment;
use App\Service\PostCRUDService;
use App\Service\DogCRUDService;
use App\Repository\PostRepository;
use App\Form\PostFormType;
use App\Form\CommentFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FeedController extends AbstractController
{
    public function index(DogCRUDService $dogService, PostRepository $postRepository): Response
    {
        $dogUser = $this->getUser();
        $dogUsername = $dogUser->getUserIdentifier();
        // dd($dogUsername);
        $postAuthor = $dogService->getDogNiceName($dogUser);
        $posts = $postRepository->findAllPostsByDog($dogUser);

        if(count($posts) === 0) {
            return $this->redirectToRoute('add_post');
        }
        
        $posts = $postRepository->findAll();

        return $this->render('feed/feed.html.twig', 
        [
            'posts' => $posts,
            'currentDogUser' => $postAuthor,
            ]
        );
    }

    public function createComment(Request $request, PostCRUDService $postService) : Response
    {
        $comment = new Comment();

        $form = $this->createForm(CommentFormType::class, $comment);

        $dogUser = $this->getUser();
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            dd("needs more work :)");
            // $postService->saveCommentForPost($dogUser, $comment, $post);
            return $this->redirectToRoute('feed');
        }

        // Rendering the view if the form has not been submitted
        return $this->render('feed/comment/add-comment.html.twig', [
            'form' => $form->createView(),
        ]);
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
        return $this->render('feed/post/add-post.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
