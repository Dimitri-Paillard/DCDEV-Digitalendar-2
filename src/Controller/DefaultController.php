<?php

namespace App\Controller;

use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {

        return $this->render('default/homepage.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    public function Event()
    {
        $event = $this->getDoctrine()->getRepository(Event::class)->findAll();

        return $this->render("default/_event.html.twig",[
            "event" => $event
        ]);
    }
}
