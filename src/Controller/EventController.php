<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    /**
     * @Route("/event", name="event")
     */
    public function index()
    {
        if ($this->getUser()->getRoles() === ['ROLE_REGISTERED']) {
            return $this->render('registration/choiceTypeRegister.html.twig');
        }
        return $this->render('event/index.html.twig');
    }
}
