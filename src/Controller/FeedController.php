<?php

namespace App\Controller;

use App\Entity\Post;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FeedController extends AbstractController
{
    public function index(): Response
    {
        

        return $this->render('feed/posts.html.twig',
        [

        ],);
    }

    public function createPost(ManagerRegistry $doctrine, Request $request): Response 
    {
        $entityManager = $doctrine->getManager();

        $post = new Post();
        $post->setCreatedAt(new \DateTimeImmutable());

        $form = $this->createForm(PostFormType::class, $post);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            
        }

    }
}
