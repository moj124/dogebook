<?php

namespace App\Controller;

use App\Entity\Dog;
use App\Service\PackService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PackController extends AbstractController
{    
    public function removeFriend(PackService $packService, Dog $dog): Response
    {
        
        $dogUser = $this->getUser();
        
        $packService->removeDogFromPack($dogUser,$dog);
        
        return $this->redirectToRoute('feed');
    }
    
    public function addFriend(PackService $packService, Dog $dog): Response
    {
        $dogUser = $this->getUser();
        $packService->addDogToPack($dogUser, $dog);
        return $this->redirectToRoute('feed');
    }
}
