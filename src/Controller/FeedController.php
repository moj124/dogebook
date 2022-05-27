<?php

namespace App\Controller;

use App\Entity\Post;

use App\Entity\Comment;
use App\Service\PostCRUDService;
use App\Service\DogCRUDService;
use App\Repository\PostRepository;
use App\Repository\CommentRepository;
use App\Form\PostFormType;
use App\Form\CommentFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FeedController extends AbstractController
{
    public function index(DogCRUDService $dogService, PostRepository $postRepository, CommentRepository $commentRepository): Response
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

        $comments = $commentRepository->findAll();

        return $this->render('feed/feed.html.twig', 
        [
            'posts' => $posts,
            'currentDogUser' => $postAuthor,
            'comments' => $comments,
            ]
        );
    }

    public function createComment(Request $request, EntityManagerInterface $em , Post $post) : Response
    {
        $comment = new Comment();
        $comment->setPost($post);
        $form = $this->createForm(CommentFormType::class, $comment);

        $dogUser = $this->getUser();
        $comment->setDog($dogUser);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($comment);
            $em->flush();
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
