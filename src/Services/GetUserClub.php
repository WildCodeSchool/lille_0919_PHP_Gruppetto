<?php


namespace App\Services;

use App\Repository\ProfilClubRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GetUserClub extends AbstractController
{

    private $userRepository;
    private $profilClubRepository;

    public function __construct(UserRepository $userRepository, ProfilClubRepository $profilClubRepository)
    {
        $this->userRepository = $userRepository;
        $this->profilClubRepository = $profilClubRepository;
    }

    public function getClub()
    {
        $user = $this->userRepository->find($this->getUser()->getId());
        if (in_array('ROLE_CLUBER', $user->getRoles())) {
            $userClubInfos = $user->getProfilClubs()->getValues()[0];
            return $userClubInfos;
        } elseif (in_array('ROLE_USER', $user->getRoles())) {
            $userClub = $user->getProfilSolo()->getProfilClub()->getId();
            $userClubInfos = $this->profilClubRepository->findOneBy(["id" => $userClub]);
            return $userClubInfos;
        } else {
            return null;
        }
    }
}
