<?php

namespace App\Controller;

use App\Entity\GeneralChatClub;
use App\Form\GeneralChatType;
use App\Repository\GeneralChatClubRepository;
use App\Services\GetUserClub;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;

/**
 * Class ClubChatController
 * @package App\Controller
 * @Route("/club/chat", name="club_chat",methods={"GET"}, options={"expose"=true})
 */
class ClubChatController extends AbstractController
{

    /**
     * @Route("", name="")
     * @return Response
     */
    public function chat(): Response
    {
        return $this->render('club_chat/index.html.twig', [
        ]);
    }

    /**
     * @return Response
     * @Route("/general", name="_general", methods={"POST", "GET"}, options={"expose"=true})
     */
    public function chatGeneral(
        GeneralChatClubRepository $clubRepository,
        Request $request,
        GetUserClub $club
    ): Response {
        $messages = $clubRepository->findBy(['profilClub' => $club->getClub()]);
        $newMessage = new GeneralChatClub();
        $form = $this->createForm(GeneralChatType::class, $newMessage);
        $form->handleRequest($request);
        $user = $this->getUser();
        if ($form->isSubmitted() && $form->isValid() && ($form['contentMessage']->getData()) != null) {
            if ($request->isXmlHttpRequest()) {
                $newMessage->setDateMessage(new DateTime('now'));
                $newMessage ->setContentMessage($_POST['general_chat']['contentMessage']);
                $newMessage->setProfilClub($club->getClub());
                if (in_array('ROLE_USER', $user->getRoles())) {
                    $newMessage->setProfilSolo($user->getProfilSolo());
                } else {
                    $newMessage->setProfilSolo(null);
                }
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($newMessage);

                $entityManager->flush();
                return new JsonResponse($newMessage, 200, [], false);
            }
        }
        return $this->render('club_chat/general.html.twig', [
            'messages' => $messages,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param GetUserClub $club
     * @Route("/getMessages", name="_get_messages", methods={"GET"}, options={"expose"=true})
     * @return JsonResponse
     */
    public function getMessages(Request $request, GetUserClub $club)
    {
        $club->getClub();
        if ($request->isXmlHttpRequest()) {
            $ema = $this->getDoctrine()->getManager();
            $messages = $ema->getRepository(GeneralChatClub::class)
                ->findBy(['profilClub' => $club->getClub()], ['id' =>'ASC']);

            $json = [];
            foreach ($messages as $message) {
                $id = $message->getId();
                $content = $message->getContentMessage();
                $date = is_null($message->getDateMessage())
                    ? null : $message->getDateMessage()->format('d-m-Y');
                $pClub = $club->getClub()->getNameClub();
                $solo = is_null($message->getProfilSolo())
                    ? null : $message->getProfilSolo()->getFirstname();
                $json[] = [
                    'messageID'=>$id,
                    'content'=> $content,
                    'clubName' => $pClub,
                    'soloName' =>$solo,
                    'dateMessage'=>$date,
                ];
            }
            $json = json_encode($json);
            return new JsonResponse($json, 200, [], true);
        }
        return new JsonResponse(null, 500, [], true);
    }
}
