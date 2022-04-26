<?php

namespace App\Entity;

use App\Repository\PostEmojiRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostEmojiRepository::class)
 */
class PostEmoji
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=7)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=dog::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $dog_id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

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
