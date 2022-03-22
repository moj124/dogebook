<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function renderHomeLandingPage(): Response
    {
       return $this->render('/homeLandingPage.html.twig');
    }
}