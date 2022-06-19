<?php

namespace App\Service;

use App\Repository\PostRepository;
use Lagdo\Symfony\Facades\Log;
use Symfony\Component\Form\FormInterface;
use App\Entity\Post;
use App\Entity\Comment;
use App\Entity\Dog;


class PostCRUDService 
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    { 
        $this->postRepository = $postRepository;
    }

    public function savePost(Post $post): void
    {   
        $this->postRepository->add($post);
    }

    /**
    * @return Post[] Returns an array of Post objects
    * @param Dog[] $dogs
    */
    public function getAllMyPackPosts(array $dogs): array
    {
        return $this->postRepository->findAllPostsByDogPack($dogs);
    }

    public function handleAddPost(Post $post, Dog $dog, FormInterface $form): bool
    {
        // is form posted in POST HTTP Response and is the form valid
        if ($form->isSubmitted() && $form->isValid()) {

            $post->setDog($dog);
            $this->postRepository->add($post);

            Log::info('PostCRUDService@handleAddPost has added a post', ['post' => $post,]);

            return true;
        }

        Log::info('PostCRUDService@handleAddPost failed to add a post', ['post' => $post,]);

        return false;
    }

    public function handleEditPost(Post $post, FormInterface $form): bool
    {
        // is form posted in POST HTTP Response and is the form valid
        if ($form->isSubmitted() && $form->isValid()) {

            $this->postRepository->add($post);

            Log::info('PostCRUDService@handleAddPost has edited a post', ['post' => $post,]);

            return true;
        }

        Log::info('PostCRUDService@handleAddPost failed to edit a post', ['post' => $post,]);

        return false;
    }

    public function addPostComment(Comment $comment, Dog $dogUser, Post $post): void
    {   
        $comment->setDog($dogUser);
        $comment->setPost($post);
        $this->commentRepository->add($comment);
    }

    
    public function removePost(Post $post): void
    {
        $this->postRepository->remove($post);
    }
}