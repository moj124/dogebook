<?php

namespace App\Service;

use App\Entity\Dog;
use App\Entity\Comment;
use App\Repository\PostRepository;
use App\Repository\CommentRepository;
use App\Entity\Post;

class PostCRUDService 
{
    private PostRepository $postRepository;
    private CommentRepository $commentRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function savePost(Post $post): void
    {   
        $this->postRepository->add($post);
    }

    public function saveCommentForPost(Dog $dogUser, Comment $comment): void 
    {
        // $this->commentRepository->setPost();
    }
}