<?php

namespace App\Controller;

use App\Form\LoginType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // Récupère l'erreur d'authentification s'il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();

        // Dernier nom entré par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();
        
        $form = $this->createForm(LoginType::class, [
            '_email' => $lastUsername,
        ]);

        return $this->render('security/login.html.twig', [
            'form' => $form->createView(),
            'error'         => $error,
        ]);
    }
}
