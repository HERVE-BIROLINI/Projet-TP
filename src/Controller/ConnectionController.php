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


/**
 * 
 * @Route("/", name="app_")
 */
class ConnectionController extends AbstractController
{
    /**
     * 
     * @Route("/connection", name="connection")
     */
    public function connection(AuthenticationUtils $authenticationUtils): Response{        

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
        $user->setInscriptiondate(new \DateTime());
        // création formulaire
        $form_register = $this->createForm(RegistrationFormType::class, $user);

        // Situation d'entrée dans le Controller/Form ($_POST = null)
        return $this->render('security/connection.html.twig', [
            'last_username' => $lastUsername, 
            'error'         => $error,
            'errPwd'        => null,
            //
            'registrationForm' => $form_register->createView(),
            // variable pour l'affichage de la DIV 
            'form_register' => $form_register
        ]);
    }


    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    //*******************************//
    // Methode au sortir des 2 forms //
    //*******************************//

    // route login by POST
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        //
        if(isset($error) && $error->getCode()==0){
            $user = new User();
            $user->setInscriptiondate (new \DateTime());
            // création formulaire
            $form_register = $this->createForm(RegistrationFormType::class, $user);
    
            $errPwd="Adresse email et/ou mot de passe invalide(s)...";
            // $this->addFlash('verify_password_error',"Error de mot de passe...");

            // Situation d'entrée dans le Controller/Form ($_POST = null)
            return $this->render('security/connection.html.twig', [
                'last_username' => $lastUsername, 
                'error'         => $error,
                'errPwd'        => $errPwd,
                //
                'registrationForm' => $form_register->createView(),
                // variable pour l'affichage de la DIV 
                'form_register' => $form_register
            ]);
        }
        // else{
            dd('on ne passe jamais là !!!!');
            // dd($this->getUser()->getFirstname());
            $this->addFlash('register-success',"Identification réussie, heureux de vous revoir".$this->getUser()->getFirstname()."...");
            return $this->redirectToRoute('homepage');
        // }
    }

    // route rgister by POST
    /**
     * @Route("/register", name="register")
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

            $this->addFlash('register-success',"Votre compte a bien été créé, nous sommes heureux de vous compter parmi nos clients...");
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
