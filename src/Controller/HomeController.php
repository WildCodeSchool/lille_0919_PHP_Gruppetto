<?php
namespace App\Controller;

use App\Form\ContactType;
use App\Repository\MailerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {

        if ($this->getUser()) {
            return $this->redirectToRoute('club_chat');
        }
        return $this->render('home/index.html.twig');
    }

    /**
     * @param MailerInterface $mailer
     * @param Request $request
     * @return Response
     * @Route("/details", name="information")
     * @throws TransportExceptionInterface
     */
    public function show(MailerInterface $mailer, Request $request): Response
    {

        $form = $this->createFormBuilder()
            ->add('nom', TextType::class)
            ->add('sujet', TextType::class)
            ->add('email', EmailType::class)
            ->add('message', TextareaType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with "name", "email", and "message" keys
            $data = $form->getData();

            $email = (new Email())
                ->from(new Address($data['email'], $data['nom']))
                ->to('ryadus2001@gmail.com')
                ->subject('Contact')
                ->text($data['message'])
                ->html($data['message'] . ' ' . '<br><small>De la part de </small>' . $data['email']);
            $mailer->send($email);
        }
        return $this->render(
            'details.html.twig',
            ['email_form' => $form->createView()]
        );
    }
}
