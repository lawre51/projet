<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\ServiceEvent;
use App\Security\EmailVerifier;
use App\Form\RegistrationFormType;
use Symfony\Component\Mime\Address;
use App\Controller\ProfileController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, 
    EntityManagerInterface $entityManager,
    AuthenticationUtils $authenticationUtils,ProfileController $profil,ServiceEvent $serviceEvent): Response
    {

        try{
            $error_message_acces_denied ='L\'utilisateur tente d\'accéder 
            à une page réservée aux administrateurs';
            //Contrôle d'accès:remplace - { path: ^/admin, roles: ROLE_USER } security.yaml
            $this->denyAccessUnlessGranted('ROLE_ADMIN', null, $error_message_acces_denied );
          }catch (AccessDeniedException  $e) {
            $serviceEvent->runEvent($e->getMessage());
            return $this->render('Blog/home.html.twig',['user'=>$profil->index(), 'message'=>$e->getMessage()]);
          }



        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        
        //throw new RfcComplianceException(sprintf('Email  does not comply with addr-spec of RFC 2822.'));
       
       
       
        if ($form->isSubmitted() && $form->isValid()) {
            
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            
            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('cyril.beaudron@gmail.com', 'Cyril'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

            ?><script>alert('Le salarié a bien été enregistré')</script><?php
            
            return $this->redirectToRoute('admin');
        }

        return $this->render('registration/register.html.twig', [
           // 'registrationForm' => $form->createView(),
           'registrationForm' => $form,
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }
}
