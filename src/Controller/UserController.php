<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Services\GetUserClub;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/profil/modify", name="modify_password")
     * @param Request $request
     * @return Response
     */
    public function edit(Request $request) : Response
    {
        // Create from for modify password

        $form=$this->createForm(UserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()) {
            $user = $this->getUser();
            $newPassword= implode($form->getData());
            $user->setPassword($newPassword);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profil_club_edit');
        }
        return $this->render('user/modify.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
