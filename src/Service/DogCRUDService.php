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
    public function getAllPosts(Dog $dog): array
    {
        return $this->postRepository->findAllPostsByDog($dog);
    }
    
    /**
    * @return Dog[]
    */
    public function getAllDogs(): array{
        return $this->dogRepository->findAll();
    }

    public function getDogNiceName(Dog $dogUser): string
    {
        return ucwords($dogUser->getUserIdentifier());
    }

    /**
     * @paramter Dog[] $dogs
     * @paramter Dog[] $myPack
     * @return Dog[]
     */
    public function getDogsNotInPack(array $myPack, array $dogs): array
    {
        if(count($myPack) === 0 || count($dogs) === 0) {
            return [];
        }

        $myPack = array_map(fn(Dog $dog): int => $dog->getId(), $myPack);

        $otherDogUsers = [];

        foreach ( $dogs as $dog) {
            if (!in_array($dog->getId(),$myPack)) {
                array_push($otherDogUsers,$dog);
            }
        }

        return $otherDogUsers;
    }
}