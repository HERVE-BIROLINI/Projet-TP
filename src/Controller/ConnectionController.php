<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ConnectionController extends AbstractController
{
    /**
     * Route("/login", name="app_login")
     * @Route("/connection", name="app_connection")
     */
    public function connection(AuthenticationUtils $authenticationUtils
                            ): Response{        

        // LOGIN
        //--
        
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // REGISTER
        //--
        // nouvelle instance de l'Entity User
        $user = new User();
        $user->setInscriptiondate (new \DateTime());
        // création formulaire
        $form_register = $this->createForm(RegistrationFormType::class, $user);

        // Situation d'entrée dans le Controller/Form ($_POST = null)
        return $this->render('security/connection.html.twig', [
            'last_username' => $lastUsername, 
            'error' => $error,
            //
            'registrationForm' => $form_register->createView(),
            // variable pour l'affichage de la DIV 
            'form_register' => $form_register
        ]);
    }


    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    //*******************************//
    // Methode au sortir des 2 forms //
    //*******************************//

    // route login by POST
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // return $this->render('security/login.html.twig', 
        // ['last_username' => $lastUsername, 'error' => $error,]);
        return $this->redirectToRoute('homepage');
        echo"<br> - entrer dans login !....";
    }

    // route rgister by POST
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request
                            , UserPasswordEncoderInterface $passwordEncoder
                            , GuardAuthenticatorHandler $guardHandler
                            , LoginFormAuthenticator $authenticator
                            ): Response{
        $user = new User();

        // birolini, ajouter pour renseigner le champs sans afficher sur la form
        $user->setInscriptiondate (new \DateTime());

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(["ROLE_USER"]);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }
        //
        return $this->render('registration/register.html.twig', [
            // return $this->render('registration/connection.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}