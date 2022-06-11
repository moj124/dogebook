<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * Dog
 *
 * @ORM\Table(name="dogs", uniqueConstraints={@ORM\UniqueConstraint(name="uniq_812c397df85e0677", columns={"username"})})
 * @ORM\Entity
 */
class Dog implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=180, nullable=false)
     */
    private $username;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="json", nullable=false)
     */
    private $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="dog", orphanRemoval=true)
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity=Notification::class, mappedBy="dog")
     */
    private $notifications;

    /**
     * @ORM\ManyToMany(targetEntity="Dog", mappedBy="myPack")
     */
    private $partOfPacks;

    /**
     * @ORM\ManyToMany(targetEntity="Dog", inversedBy="partOfPacks")
     * @ORM\JoinTable(name="packs",
     *      joinColumns={@ORM\JoinColumn(name="dog_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="pack_dog_id", referencedColumnName="id")}
     * )
     */
    private $myPack;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->myPack = new ArrayCollection();
        $this->partOfPacks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setDog($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            $this->posts->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getDog() === $this) {
                $post->setDog(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setDog($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getDog() === $this) {
                $notification->setDog(null);
            }
        }

        return $this;
    }

    public function removeDogFromPack(Dog $dog): self
    {
        if($this->myPack->contains($dog)) {
            $this->myPack->removeElement($dog);
            $this->partOfPacks->removeElement($dog);
        }

        return $this;
    }

    public function getPartOfPacks()
    {
        return $this->partOfPacks;
    }

    public function setPartOfPacks(Dog $dog): self
    {
        if (!$this->partOfPacks->contains($dog)) {
            $this->getPartOfPacks()->add($dog);
            $dog->getMyPack()->add($this);
        }

        return $this;
    }

    /**
     * Get joinColumns={@ORM\joinColumn(name="dog_id", referencedColumnName="id)},
     */
    public function getMyPack()
    {
        return $this->myPack;
    }

    /**
     * Set joinColumns={@ORM\joinColumn(name="dog_id", referencedColumnName="id)},
     */
    public function setMyPack(Dog $dog): self
    {
        if (!$this->myPack->contains($dog)) {
            $this->getMyPack()->add($dog);
            $dog->getPartOfPacks()->add($this);
        }

        return $this;
    }
}
