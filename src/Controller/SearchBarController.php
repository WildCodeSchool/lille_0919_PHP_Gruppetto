<?php

namespace App\Controller;

use App\Entity\ProfilSolo;
use App\Services\GetUserClub;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SearchBarController
 * @package App\Controller
 * @Route("/searchbar", name="searchbar", methods={"GET"}, options={"expose"=true})
 */
class SearchBarController extends AbstractController
{
    /**
     * @Route("/getClubMembers/{joker}", name="_getMembers", methods={"POST"}, options={"expose"=true})
     */
    public function getClubMembers(Request $request, GetUserClub $club, $joker): Response
    {

        if ($request->isXmlHttpRequest()) {
            $entityManager = $this->getDoctrine()->getManager();
            $members = $entityManager->getRepository(ProfilSolo::class)
                ->findBy([
                    'profilClub' => $club->getClub()->getId()
                ], ['lastname' => 'ASC']);

            $joker = strtolower($joker);
            foreach ($members as $member) {
                    $lastname = strtolower($member->getLastname());
                    $firstname = strtolower($member->getFirstname());

                if ((strpos($firstname, "$joker") !== false) || (strpos($lastname, "$joker") !== false)) {
                    $firstname = ucfirst($firstname);
                    $lastname = ucfirst($lastname);
                    $json[] = [
                        'fullname' => "$firstname $lastname",
                    ];
                }
            }

            $json = json_encode($json);

            return new JsonResponse($json, 200, [], true);
        }

        $json[] = ['fullname' => 'Pas de resultat'];
        $json = json_encode($json);
        return new JsonResponse($json, 500, [], true);
    }
}
