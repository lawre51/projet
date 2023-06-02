<?php

namespace App\Controller;

use App\Controller\ProfileController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomeController extends AbstractController
{
    #[Route('/accueil', name: 'accueil')]
    
    public function index(AuthenticationUtils $authenticationUtils,ProfileController $profil): Response
      {
        $message="Bienvenue";
        //Vérificaion de la connexion de l'utilisateur
        if( !$this->isGranted('IS_AUTHENTICATED_FULLY')){
            $message = "Utilisateur non connecté";
        }

       
        return $this->render('Blog/home.html.twig',['message'=>$message]);
       
      }
}