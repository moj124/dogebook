<?php

namespace App\Controller;

use App\Entity\Post;

use App\Service\PostCRUDService;
use App\Service\DogCRUDService;
use App\Repository\PostRepository;
use App\Form\PostFormType;
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

    // public function addComment(DogCRUDService $dogService, PostRepository $postRepository) : Response
    // {

    // }

    public function createPost(Request $request, PostCRUDService $postService, DogCRUDService $dogService): Response 
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
