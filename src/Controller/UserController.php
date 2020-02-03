<?php

namespace App\Controller;

use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/profil/modify", name="modify_password")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function edit(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder
    ) : Response {
        // Create from for modify password
        $user=$this->getUser();
        $form=$this->createForm(UserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()) {
            $oldPassword = $form['oldPassword']->getData();

            $isPasswordValid = $passwordEncoder->isPasswordValid($user, $oldPassword);

            if ($isPasswordValid== true) {
                $newPassword=$form['password']->getData();
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $newPassword
                    )
                );
                $entityManager->flush();
                return $this->redirectToRoute('profil_club_edit');
            } else {
                $this->addFlash(
                    'notice',
                    'Votre ancien mot de passe ne correspond pas'
                );
            }
        }
        return $this->render('user/modify.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
