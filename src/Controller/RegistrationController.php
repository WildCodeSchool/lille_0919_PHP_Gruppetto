<?php

namespace App\Controller;

use App\Entity\ProfilClub;
use App\Entity\ProfilSolo;
use App\Entity\User;
use App\Form\InformationClubFormType;
use App\Form\InformationSoloFormType;
use App\Form\RegistrationFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class RegistrationController
 * @package App\Controller
 * @SuppressWarnings("undefined")
 */
class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        if ($this->getUser() && in_array('ROLE_USER', $this->getUser()->getRoles())) {
            return $this->redirectToRoute('event');
        }

        $user = new User();
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
            $user->setRoles(['ROLE_REGISTERED']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Félicitations, vous avez fait votre premier pas chez Gruppetto !!!'
            );

            // automatically connects the user
            $token = new UsernamePasswordToken(
                $user,
                $passwordEncoder,
                'main',
                $user->getRoles()
            );
            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));

            return $this->render('registration/choiceTypeRegister.html.twig');
        }
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/register/club/information", name="app_club_register_informations")
     * @param Request $request
     * @return Response
     * @IsGranted("ROLE_REGISTERED")
     */
    public function informationClub(Request $request): Response
    {

        $this->denyAccessUnlessGranted('ROLE_REGISTERED');

        $profilClub = new ProfilClub();
        $profilClub->setNameClub('');
        $profilClub->setCityClub('');
        $profilClub->setDescriptionClub('');

        $form = $this->createForm(InformationClubFormType::class, $profilClub);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            if (is_null($form['logoClub']->getData())) {
                $profilClub->setLogoClub('no_avatar.jpg');
            } else {
                $profilClub->setLogoClub($form['logoClub']->getData());
                $logoClub=md5(uniqid()) . '.' . $profilClub->guessExtension();
                $profilClub->setLogoClub($logoClub);
            }

            $profilClub->setSport($form['sport']->getData());

            // setting roles for a club

            $this->getUser()->setRoles(['ROLE_CLUBER']);

            // linking user to ProfilClub
            $profilClub->addUser($this->getUser());
            $entityManager->persist($profilClub);
            $entityManager->persist($this->getUser());
            $entityManager->flush();
            $this->addFlash(
                'notice',
                "Il ne vous reste plus q'à vous connecter !"
            );

            return $this->redirectToRoute('app_login');
        }
        return $this->render('registration/infoClubRegister.html.twig', [
            'registrationForm2' => $form->createView(),
        ]);
    }



    /**
     * @Route("/register/solo/informations", name="app_solo_register_informations")
     * @param Request $request
     * @return Response
     */
    public function informationSolo(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_REGISTERED');

        $profilSolo = new ProfilSolo();
        $profilSolo->setFirstname('');
        $profilSolo->setLastname('');

        $form = $this->createForm(InformationSoloFormType::class, $profilSolo);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            if (is_null($form['avatar']->getData())) {
                $profilSolo->setAvatar('no_avatar.jpg');
            } else {
                $profilSolo->setAvatar($form['avatar']->getData());
                $logoClub=md5(uniqid()) . '.' . $profilSolo->guessExtension();
                $profilSolo->setAvatar($logoClub);
            }

            // setting roles for a club

            $this->getUser()->setRoles(['ROLE_USER']);

            // linking user to ProfilClub
            $profilSolo->setUser($this->getUser());
            $entityManager->persist($profilSolo);
            $entityManager->persist($this->getUser());
            $entityManager->flush();
            $this->addFlash(
                'notice',
                "Il ne vous reste plus q'à vous connecter !"
            );

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/infoSoloRegister.html.twig', [
            'registrationForm3' => $form->createView(),
        ]);
    }
}
