<?php

namespace App\Controller;

use App\Entity\ProfilClub;
use App\Entity\User;
use App\Form\ProfilClubType;
use App\Form\UserType;
use App\Repository\ProfilClubRepository;
use App\Services\GetUserClub;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profil/club")
 */
class ProfilClubController extends AbstractController
{

    /**
     * @Route("/", name="profil_club_edit", methods={"GET","POST"})
     * @param Request $request
     * @param GetUserClub $club
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @IsGranted("ROLE_USER")
     */

    public function edit(Request $request, GetUserClub $club, EntityManagerInterface $entityManager): Response
    {
        // create form for profil club
        $form = $this->createForm(ProfilClubType::class, $club->getClub());
        $form->handleRequest($request);
        $thisClub = $entityManager->getRepository(ProfilClub::class)
            ->find($club->getClub());

        if ($form->isSubmitted() && $form->isValid()) {
            $logoFile =$form['logoClub']->getData();

            if ($logoFile) {
                $logoFileName = md5(uniqid()). '.'.$logoFile->guessExtension();
                // Move the file to the directory where brochures are stored
                $logoFile->move($this->getParameter('upload_directory'), $logoFileName);
                $thisClub->setLogoClub($logoFileName);
            }
            $entityManager->flush();
        }

        return $this->render('profil_club/show.html.twig', [
            'profil_club' => $thisClub,
            'form' => $form->createView(),
        ]);
    }
}
