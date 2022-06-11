<?php

namespace App\Service;

use App\Entity\Dog;
use App\Domain\Facade\Cache;
use App\Message\ActivityEvents\FriendAddedEvent;
use App\Repository\DogRepository;
use Lagdo\Symfony\Facades\Log;
use Psr\Cache\CacheItemInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class PackService
{
    private DogRepository $dogRepo;
    private MessageBusInterface $bus;
    const PACK_IDENTIFIER = "PACK_ID_";

    public function __construct(DogRepository $dogRepo, MessageBusInterface $bus)
    {
        $this->dogRepo = $dogRepo;
        $this->bus = $bus;
    }

    /**
    * @return Dog[]
    */
    public function getPack(Dog $dog): array
    {
        return Cache::get(self::PACK_IDENTIFIER . $dog->getId(), 
            function (CacheItemInterface $item) use ($dog) {
            $friendsList = $item->set($this->dogRepo->getDogsPack($dog))
                ->expiresAfter(3600);
            
            return $friendsList->get();
        });
    }

    public function addDogToPack(Dog $alpha, Dog $beta): void
    {
        $alpha->setPartOfPacks($beta);
        $beta->setPartOfPacks($alpha);

        $this->dogRepo->add($alpha);
        $this->dogRepo->add($beta);

        Cache::delete(self::PACK_IDENTIFIER . $alpha->getId());
        Cache::delete(self::PACK_IDENTIFIER . $beta->getId());

        $this->bus->dispatch(new FriendAddedEvent($alpha, $beta));

        Log::info(`PackService@addDogToPack has added alpha Dog & beta Dog to each other's packs`, ['alpha' => $alpha, 'beta' => $beta],);
    }

    /**
     * @paramter Dog[] $dogs
     * @paramter Dog[] $myPack
     * @return Dog[]
     */
    public function getDogsNotInPack(Dog $dogUser,array $myPack, array $dogs): array
    {
        if(count($dogs) === 0) {
            return $dogs;
        }

        $myPack = array_map(fn(Dog $dog): int => $dog->getId(), $myPack);

        $otherDogUsers = [];

        foreach ( $dogs as $dog) {
            if (!in_array($dog->getId(),$myPack) && $dog->getId() !== $dogUser->getId()) {
                array_push($otherDogUsers,$dog);
            }
        }

        return $otherDogUsers;
    }

    public function removeDogFromPack(Dog $dogUser, Dog $dog): void
    {
        $dogUser->removeDogFromPack($dog);
        $dog->removeDogFromPack($dogUser);

        $this->dogRepo->add($dogUser);
        $this->dogRepo->add($dog);

        Cache::delete(self::PACK_IDENTIFIER . $dogUser->getId());
        Cache::delete(self::PACK_IDENTIFIER . $dog->getId());

        Log::info(`PackService@removeDogToPack has been removed from Dog's Packs`, ['dog' => $dog,],);
    }
}
