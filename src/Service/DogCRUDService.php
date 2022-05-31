<?php

namespace App\Service;

use App\Repository\DogRepository;
use App\Repository\PostRepository;
use App\Entity\Dog;
use App\Entity\Post;

class DogCRUDService 
{
    private DogRepository $dogRepository;
    private PostRepository $postRepository;

    public function __construct(DogRepository $dogRepository, PostRepository $postRepository)
    {
        $this->dogRepository = $dogRepository;
        $this->postRepository = $postRepository;
    }

    /**
     * @accepts Dog $dog
     * @returns void
     */
    public function saveDog(Dog $dog): void
    {
        $this->dogRepository->add($dog);
    }

    public function savePostForDog(Dog $dog,Post $post): void
    {
        $post->setDog($dog);
        $this->postRepository->add($post);
    }

    /**
     * @accepts Dog $dog
     * @return Post[]
     */
    public function getAllPosts(Dog $dog): iterable
    {
        return $this->postRepository->findAllPostsByDog($dog);
    }

    public function getAllFriendsPosts(){
        return null;
    }

    public function getDogNiceName(Dog $dogUser): string {
        return ucwords($dogUser->getUserIdentifier());
    }
}