<?php

namespace App\Controller;

use App\Entity\ProfilSolo;
use App\Services\GetUserClub;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SearchBarController
 * @package App\Controller
 * @Route("/searchbar", name="searchbar", methods={"GET"}, options={"expose"=true})
 */
class SearchBarController extends AbstractController
{
    /**
     * @Route("/getClubMembers", name="_getMembers", methods={"GET"}, options={"expose"=true})
     */
    public function getClubMembers(Request $request, GetUserClub $club)
    {
        if ($request->isXmlHttpRequest()) {
            $entityManager = $this->getDoctrine()->getManager();
            $members = $entityManager->getRepository(ProfilSolo::class)
                ->findBy([
                    'profilClub' => $club->getClub(),
                ], ['lastname' => 'ASC']);

            $json = [];
            foreach ($members as $member) {
                $lastname = $member->getLastname();
                $firstname = $member->getFirstname();
                $json[] = [
                    'lastname' => $lastname,
                    'firstname' => $firstname,
                ];
                $json = json_encode($json);
                return new JsonResponse($json, 200, [], true);
            }
        }
        return new JsonResponse(null, 500, [], true);
    }
}
