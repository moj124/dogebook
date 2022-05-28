<?php

namespace App\Service;

use App\Repository\CommentRepository;
use App\Entity\Comment;
use App\Entity\Dog;
use App\Entity\Post;

class CommentCRUDService 
{
    private CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }
}