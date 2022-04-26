<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=dog::class, inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dog_id;

    /**
     * @ORM\Column(type="text")
     */
    private $post_text;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPostText(): ?string
    {
        return $this->post_text;
    }

    public function setPostText(string $post_text): self
    {
        $this->post_text = $post_text;

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
