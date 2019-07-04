<?php

namespace App\Controller;

use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="account")
     */
    public function index()
    {
        $event = $this->getDoctrine()->getRepository(Event::class)->findAll();

        return $this->render('account/account.html.twig', [
            'controller_name' => 'AccountController',
            'event' => $event
        ]);
    }
    public function Event()
    {
        $event = $this->getDoctrine()->getRepository(Event::class)->findAll();

        return $this->render("account/_event.html.twig",[
            "event" => $event
        ]);
    }
}
