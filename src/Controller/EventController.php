<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Participant;
use App\Form\EventType;
use App\Repository\EventRepository;
use App\Service\Slugger;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="event_index", methods={"GET"})
     *
     */
    public function index(EventRepository $eventRepository): Response
    {
        return $this->render('event/index.html.twig', [
            'event' => $eventRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="event_new", methods={"GET","POST"})
     */
    public function new(Request $request,Slugger $slugger): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $pictureFile */
            $pictureFile = $form["pictureFile"]->getData();

            if ($pictureFile)
            {
                $fileName = uniqid() . "." . $pictureFile->guessExtension();

                $pictureFile->move($this->getParameter("upload_dir"),$fileName);

                $event->setPicture($fileName);
            }
            $event->setSlug($slugger->slugify($event->getTitle()));
            $event->setUser($this->getUser());
            $event->setIsValid(false);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute("event_index",["slug" => $event->getSlug()]);
        }

        return $this->render('event/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="event_show", methods={"GET"})
     */
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }
    /**
     * @Route("/{slug}/add-participant", name="event_add_participant", methods={"GET"})
     */
    public function addParticipant(Event $event): Response
    {
        $em = $this->getDoctrine()->getManager();

        // Vérifier si l'utilisateur participe déjà
        $participant = $em->getRepository(Participant::class)->findOneBy(["user" => $this->getUser(), "event" => $event]);

        if ($participant) {
            $em->remove($participant); // Supprimer la participation
        } else {
            // Ajouter la participation
            $participant = new Participant();
            $participant->setUser($this->getUser());
            $participant->setEvent($event);
            $participant->setCreatedAt(new \DateTime());

            $em->persist($participant);
        }

        $em->flush();

        return $this->redirectToRoute("event_show", ["slug" => $event->getSlug()]);
    }

    /**
     * @Route("/{slug}/edit", name="event_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Event $event): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_index', [
                'id' => $event->getId(),
                'slug' => $event->getSlug(),
            ]);
        }

        return $this->render('event/edit.html.twig', [
            'form' => $form->createView(),
            'event' => $event
        ]);
    }
    /**
     * @Route("/{slug}", name="event_delete", methods={"DELETE"})
     * @IsGranted("ROLE_USER")
     */
    public function delete(Request $request, Event $event): Response
    {
        if ($this->isCsrfTokenValid('delete' . $event->getSlug(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();

        }

        return $this->redirectToRoute('event_index', [
            'id' => $event->getId(),
            'slug' => $event->getSlug(),
        ]);
    }
}
