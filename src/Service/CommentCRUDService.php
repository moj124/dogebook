<?php

namespace App\Service;

use App\Repository\CommentRepository;
use Lagdo\Symfony\Facades\Log;
use Symfony\Component\Form\FormInterface;
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

    public function assignPost(Comment $comment, Post $post): void {
        $comment->setPost($post);
    }

    public function assignDog(Comment $comment, Dog $dog): void {
        $comment->setDog($dog);
    }

    public function handleAddComment(Comment $comment, Post $post, Dog $dog, FormInterface $form): bool
    {
        // is form posted in POST HTTP Response and is the form valid
        if ($form->isSubmitted() && $form->isValid()) {

            $this->assignPost($comment, $post);
            $this->assignDog($comment, $dog);
            $this->commentRepository->add($comment);

            Log::info('CommentCRUDService@handleAddComment has added a comment', ['comment' => $comment, 'post' => $post, 'dog' => $dog]);


            return true;
        }

        Log::info('CommentCRUDService@handleAddComment failed to add a comment', ['comment' => $comment, 'post' => $post, 'dog' => $dog]);

        return false;
    }
}