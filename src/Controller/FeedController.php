<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Comment;
use App\Entity\Dog;
use App\Service\DogCRUDService;
use App\Service\CommentCRUDService;
use App\Service\PackService;
use App\Repository\PostRepository;
use App\Repository\CommentRepository;
use App\Repository\DogRepository;
use App\Form\PostFormType;
use App\Form\CommentFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FeedController extends AbstractController
{
    public function index(
        DogCRUDService $dogService,
        PostRepository $postRepository, 
        CommentRepository $commentRepository, 
        DogRepository $dogRepository, 
        PackService $packService
        ): Response 
    {

        $dogUser = $this->getUser();

        $postAuthor = $dogService->getDogNiceName($dogUser);

        $posts = $postRepository->findAllPostsByDog($dogUser);

        if(count($posts) === 0) {
            return $this->redirectToRoute('add_post');
        }
        

        // move this when you add a pack
        $posts = $postRepository->findAll();

        $comments = $commentRepository->findAll();

        $myPack = $packService->getPack($dogUser);

        // dd($myPack);
        $dogs = $dogRepository->findAll();

        // dd($dogs);
        $otherDogUsers = array_udiff($dogs, $myPack, function(Dog $dog, Dog $packDog) {
            return $dog->getId() !== $packDog->getId(); 
        });
        
        // dd($otherDogUsers);

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
