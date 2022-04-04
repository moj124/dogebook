<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function index(): Response
    {
       return $this->render('/homeLandingPage.html.twig');
    }

    public function renderAboutPage(): Response
    {
       return $this->render('about-us/index.html.twig', ['user' => $this->getUser()]);
    }

    public function renderContactUsPage(): Response
    {
       return $this->render('');
    }
}