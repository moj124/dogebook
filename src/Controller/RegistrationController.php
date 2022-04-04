<?php

namespace App\Controller;

use App\Entity\Dog;
use App\Form\RegistrationFormType;
use App\Service\RegistrationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    public function index() : Response 
    {
        // Create the entity and send to view to be rendered (cool thing called two way databinding)
        $dog = new Dog();
        $form = $this->createForm(RegistrationFormType::class, $dog);

        return $this->render('registration/register.html.twig',['registrationForm' => $form->createView(),]);
    }

    public function renderRegisterWelcomePage() : Response 
    {
        return $this->render('');
    }

    public function register(Request $request, RegistrationService $registrationService) : Response
    {
        // Create the entity and send to view to be rendered (cool thing called two way databinding)
        $dog = new Dog();
        $form = $this->createForm(RegistrationFormType::class, $dog);

        // Interesting thing Symfony does where a route can handle both POST and GET
        // could we only do the POST functionality instead?
        // --------------------------
        $form->handleRequest($request);
        //---------------------------
        // Saving the dog if the form is submitted and valid
        if($registrationService->handleRegistration($dog, $form)){
            return $this->render('This worked. HoORAY');
        }

        // Rendering the view if the form has not been submitted
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
