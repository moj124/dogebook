<?php

namespace App\Controller;

use App\Service\DogImageService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function index(DogImageService $dogImageService): Response
    {
       $imageString = $dogImageService->getRandomDogImageString();
       
       return $this->render('home/landingPage.html.twig', [
          'imageSrc' => $imageString
       ]);
    }

    public function aboutUs(): Response
    {
       return $this->render('home/about-us.html.twig');
    }

    public function contactUs(): Response
    {
       return $this->render('home/contact-us.html.twig');
    }
}