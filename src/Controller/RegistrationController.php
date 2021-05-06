<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccessFormType;
use App\Form\AccountFormType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Constraints\NotBlank;


/**
 * Route("/", name="app_")
 */
class RegistrationController extends AbstractController
{
    /** DESACTIVEE AU PROFIT DE CELLE DANS CONNECTIONCONTROLLER
     * Route("/register", name="register")
     */
    public function register(Request $request
                            , UserPasswordEncoderInterface $passwordEncoder
                            , GuardAuthenticatorHandler $guardHandler
                            , LoginFormAuthenticator $authenticator
                            ): Response
    {
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

        return $this->render('registration/register.html.twig', [
            // return $this->render('registration/connection.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }


    /**
     * @Route("/account/{id}", name="app_account", methods={"GET","POST"})
     */
    public function account(Request $request
                            , User $id
                            , UserRepository $repository
                            , GuardAuthenticatorHandler $guardHandler
                            , LoginFormAuthenticator $authenticator
                            ){
        $user = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->find($id);
        //
        $form = $this->createForm(AccountFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user=$form->getData();
            //
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('change-account',"Vos modifications ont bien été prises en compte...");
        }

        return $this->render('registration/account.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/access/{id}", name="app_access", methods={"GET","POST"})
     */
    public function access(Request $request
                            , User $id
                            , UserRepository $repository
                            , GuardAuthenticatorHandler $guardHandler
                            , LoginFormAuthenticator $authenticator
                            , UserPasswordEncoderInterface $passwordEncoder
                            , AuthenticationUtils $authenticationUtils
                            ): Response{

        $user = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->find($id);

        $form = $this->createForm(AccessFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            if(isset($_POST['password-old']) 
                // && preg_match("@^[a-z0-9]+@i", $_POST['password-old']==1)
                && password_verify ($_POST['password-old'] , $user->getPassword() )
            ){
                // encode the plain password
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
                //
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                
                // get the login error if there is one
                $error = $authenticationUtils->getLastAuthenticationError();
                // last username entered by the user
                $lastUsername = $authenticationUtils->getLastUsername();

                // puisque mdp changé avec succès, retour à la vue Compte utilisateurs
                $form = $this->createForm(AccountFormType::class, $user);
                $form->handleRequest($request);

                
            $this->addFlash('change-account',"Votre mot de passe a bien été modifié...");
                return $this->render('registration/account.html.twig',[
                    'registrationForm'  => $form->createView(),
                    ]
                );
            }
            else{
                $this->addFlash('verify_password_error',"Error de mot de passe actuel...");
            }
        }

        return $this->render('registration/access.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
