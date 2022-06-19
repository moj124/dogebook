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

    /**
     * @paramter Comment[] $posts
     * @return Comment[] 
     */ 
    public function getAllCommentsByPosts(array $posts): array {
        return $this->commentRepository->findAllCommentsByPosts($posts);
    }

    public function assignPost(Comment $comment, Post $post): void {
        $comment->setPost($post);

        Log::info('CommentCRUDService@assignPosthas added a Post relation', ['comment' => $comment, 'post' => $post]);
    }

    public function assignDog(Comment $comment, Dog $dog): void {
        $comment->setDog($dog);

        Log::info('CommentCRUDService@assignDog has added a Dog relation', ['comment' => $comment, 'dog' => $dog]);
    }

    public function handleEditComment(Comment $comment, FormInterface $form): bool
    {
        // is form commented in POST HTTP Response and is the form valid
        if ($form->isSubmitted() && $form->isValid()) {

            $this->commentRepository->add($comment);

            Log::info('CommentCRUDService@handleAddComment has edited a comment', ['comment' => $comment,]);

            return true;
        }

        Log::info('CommentCRUDService@handleAddComment failed to edit a comment', ['comment' => $comment,]);

        return false;
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

    public function removeComment(Comment $comment): bool
    {
        if($this->commentRepository->findOneByID($comment)){
            $this->commentRepository->remove($comment);
            return true;
        }

        return false;
    }
}