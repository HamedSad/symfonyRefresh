<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController{
    
    /**
    *
    *@Route("/login", name="login")
    *
    */
    //Injection de la class AuthentificationUtils qui permet d'accéder à 2 fonctionnalités d'authentification
    public function login(AuthenticationUtils $authenticationUtils){
        //Dans AuthentificationUtils on va avoir la methode lastUserName qui permet de récupérer le dernier user
        $lastUsername = $authenticationUtils->getLastUsername();
        $error = $authenticationUtils->getLastAuthenticationError();
        return $this->render('security/login.html.twig', [
            //Dernier username que l'on injecte ensuite dans notre vue, on récupère la valeur de cette variable
            'last_username' =>$lastUsername,
            //Récupérer la dernière erreur avec la methode authentificationError
            'error' =>$error
        ]);
    }
}