<?php

namespace App\Controller;

use App\Entity\Dog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends AbstractController
{
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('auth/login/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    public function renderResetPasswordPage(): Response
    {
        return $this->render('');
    }

    public function reset_password(Request $request): Response
    {
        // Create the entity and send to view to be rendered (cool thing called two way databinding)
        $dog = new Dog();
        $form = $this->createForm(RegistrationFormType::class, $dog);

        $form->handleRequest($request);

        return $this->render('');
    }

    // This is intercepted by Symfony magic. No need for an implemention
    public function logout()
    {
    }
}
