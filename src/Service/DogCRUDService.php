<?php

namespace App\Service;

use App\Repository\DogRepository;
use App\Entity\Dog;

class DogCRUDService 
{
    private DogRepository $dogRepository;

    public function __construct(DogRepository $dogRepository)
    {
        $this->dogRepository = $dogRepository;
    }

    /**
     * @accepts Dog $dog
     * @returns void
     */
    public function saveDog(Dog $dog): void
    {
        $this->dogRepository->add($dog);
    }

}