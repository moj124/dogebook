<?php

namespace App\Controller;

use App\Entity\Dog;
use App\Form\RegistrationFormType;
use App\Service\DogCRUDService;
use App\Service\RegistrationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    public function register(Request $request, RegistrationService $regService, DogCRUDService $dogService) : Response
    {
        $dog = new Dog();
        $form = $this->createForm(RegistrationFormType::class, $dog);
        $form->handleRequest($request);
        $regService->handleRegistration($dog, $form, $dogService);

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
