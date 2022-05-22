<?php

namespace App\Service;

use App\Entity\Dog;
use App\Domain\Facade\Cache;
use App\Message\ActivityEvents\FriendAddedEvent;
use App\Repository\DogRepository;
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
    }
}
