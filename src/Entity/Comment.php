<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=post::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $post_id;

    /**
     * @ORM\ManyToOne(targetEntity=dog::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $dog_id;

    /**
     * @ORM\Column(type="text")
     */
    private $comment_text;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostId(): ?post
    {
        return $this->post_id;
    }

    public function setPostId(?post $post_id): self
    {
        $this->post_id = $post_id;

        return $this;
    }

    public function getDogId(): ?dog
    {
        return $this->dog_id;
    }

    public function setDogId(?dog $dog_id): self
    {
        $this->dog_id = $dog_id;

        return $this;
    }

    public function getCommentText(): ?string
    {
        return $this->comment_text;
    }

    public function setCommentText(string $comment_text): self
    {
        $this->comment_text = $comment_text;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
