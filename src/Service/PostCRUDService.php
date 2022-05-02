<?php

namespace App\Service;

use App\Repository\PostRepository;
use App\Entity\Post;

class PostCRUDService 
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @accepts Dog $dog
     * @returns void
     */
    public function savePost(Post $post): void
    {
        $this->postRepository->add($post);
    }
}