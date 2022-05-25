<?php

namespace App\Service;

use App\Repository\CommentRepository;
use App\Entity\Comment;

class CommentCRUDService 
{
    private CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function saveComment(Comment $comment): void
    {   
        $this->commentRepository->add($comment);
    }
}