<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordHasherInterface $hash, EntityManagerInterface $entityManager): Response
    {
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $passwordHash = $hash->hashPassword($user, $user->getPassword());

            $user->setPassword($passwordHash);
            $user->setRoles(["ROLE_USER"]);

            $entityManager->persist($user);
            $entityManager->flush();   // $_SESSION ['success'] =  "Félicitations! votre compte a bien été enregistré \r \n vous pouvez dès à présent vous connecter"
            // do anything else you need here, like send an email

            $this->addFlash('success', "Félicitations! votre compte a bien été enregistré \r \n vous pouvez dès à présent vous connecter");

            return $this->redirectToRoute('login');

        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
