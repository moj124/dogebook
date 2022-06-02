<?php

namespace App\Service;

use App\Repository\PostRepository;
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

    public function addPostComment(Comment $comment, Dog $dogUser, Post $post): void
    {   
        $comment->setDog($dogUser);
        $comment->setPost($post);
        $this->commentRepository->add($comment);
    }
}