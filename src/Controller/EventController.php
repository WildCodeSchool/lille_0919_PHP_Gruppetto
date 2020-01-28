<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\ParticipationLike;
use App\Form\EventType;
use App\Repository\EventRepository;
use App\Repository\ParticipationLikeRepository;
use App\Services\GetUserClub;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="event", methods={"GET", "POST"}, options={"expose"=true})
     * @param GetUserClub $club
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function index(GetUserClub $club): Response
    {

        $ema = $this->getDoctrine()->getManager();
        $events = $ema->getRepository(Event::class)
            ->findBy(['creatorClub'=>$club->getClub()]);
        return $this->render('event/index.html.twig', [
            'events' => $events,
        ]);
    }

    /**
     * @Route("/new", name="event_new", methods={"GET","POST"})
     * @param Request $request
     * @param GetUserClub $club
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @IsGranted("ROLE_CLUBER")
     */
    public function new(Request $request, GetUserClub $club, EntityManagerInterface $entityManager): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event->setCreatorClub($club->getClub());
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('event');
        }

        return $this->render('event/new.html.twig', [

            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_show", methods={"GET"})
     * @param EventRepository $eventRepository
     * @param Event $event
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function show(EventRepository $eventRepository, Event $event): Response
    {
        $participants = $this->getParticipants($event);

        return $this->render('event/show.html.twig', [
            'events' => $eventRepository->findAll(),
            'event' => $event,
            'participants' => $participants
        ]);
    }

    /**
     * @param Event $event
     */
    public function getParticipants(Event $event)
    {

        $entityManager = $this->getDoctrine()->getRepository(ParticipationLike::class);
        $participantList = $entityManager->findBy([
            'event'=> $event
        ]);

        $list = [];
        foreach ($participantList as $participant) {
            $list[]= [
                    'firstname' => $participant->getUser()->getProfilSolo()->getFirstname(),
                    'lastname' => $participant->getUser()->getProfilSolo()->getLastname(),
                    'avatar' => $participant->getUser()->getProfilSolo()->getAvatar(),
                ];
        }
            return $list;
    }

    /**
     * @Route("/{id}/edit", name="event_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Event $event
     * @return Response
     * @IsGranted("ROLE_CLUBER")
     */
    public function edit(Request $request, Event $event): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event');
        }

        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_delete", methods={"DELETE"})
     * @param Request $request
     * @param Event $event
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @IsGranted("ROLE_CLUBER")
     */
    public function delete(Request $request, Event $event, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $event->getId(), $request->request->get('_token'))) {
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event');
    }

    /**
     * Allows you to participate and no longer participate
     * @Route("/{id}/participe", name="event_participe")
     * @param Event $event
     * @param ObjectManager $manager
     * @param ParticipationLikeRepository $participationRepo
     * @return Response
     */
    public function participation(
        Event $event,
        ObjectManager $manager,
        ParticipationLikeRepository $participationRepo
    ) : Response {
        $user = $this->getUser();

        if (!$user) {
            return $this->json([
            'code'=>403,
            'message'=>"Connectez vous"
            ], 403);
        }

        if ($event->isParticipationByUser($user)) {
            $participationLike = $participationRepo->findOneBy([
                'event'=>$event,
                'user'=>$user
            ]);

            $manager->remove($participationLike);
            $manager->flush();

            return $this->json([
                'code'=>200,
                'message'=>"Participation supprimée",
                'participationLikes'=> $participationRepo->count(['event'=> $event]),
                ], 200);
        }

        $participationLike = new ParticipationLike();
        $participationLike->setEvent($event)
            ->setUser($user);

        $manager->persist($participationLike);
        $manager->flush();


        return $this->json([
            'code' => 200,
            'message' => 'Participation acceptée',
            'participationLikes'=> $participationRepo->count(['event'=> $event])
        ], 200);
    }
}
