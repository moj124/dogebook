<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController
{
    /**
     * @Route("/", name="home")
     */
    public function renderHomeLandingPage(): Response
    {
        return new Response(
            '<html><body> Welcome! </body></html>'
        );
    }
}