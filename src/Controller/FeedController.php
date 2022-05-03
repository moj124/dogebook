<?php

namespace App\Controller;

use App\Entity\Post;
use App\Service\PostCRUDService;
use App\Form\PostFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FeedController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('feed/feed.html.twig');
    }

    public function createPost(Request $request, PostCRUDService $postService): Response 
    {
        $post = new Post();

        $form = $this->createForm(PostFormType::class, $post);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $postService->savePost($post);
            return $this->redirectToRoute('/feed');
        }

        // Rendering the view if the form has not been submitted
        return $this->render('feed/post/add-post.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
