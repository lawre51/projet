<?php

namespace App\Controller;

use App\Controller\ProfileController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use App\Service\ServiceEvent;

class AdminController extends AbstractController
{
  
  #[Route('/admin', name: 'admin')]
    
  public function index(AuthenticationUtils $authenticationUtils,ProfileController $profil,ServiceEvent $serviceEvent): Response
    {

      try{
        $error_message_acces_denied ='L\'utilisateur tente d\'accéder 
        à une page réservée aux administrateurs';
        //Contrôle d'accès:remplace - { path: ^/admin, roles: ROLE_USER } security.yaml
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, $error_message_acces_denied );
      }catch (AccessDeniedException $e) {
        //Appel l'action du service qui va déclencher un évènement
        $serviceEvent->runEvent($e->getMessage());
        return $this->render('Blog/home.html.twig',['user'=>$profil->index(), 'message'=>$e->getMessage()]);
      }

  return $this->render('Admin/admin.html.twig',['user'=>$profil->index()]);
         
  }

  
}