<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use App\Form\Event1Type;
use App\Form\EventType;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/concert")
 */
class ConcertController extends AbstractController
{
    /**
     * @Route("/", name="admin_concert_index", methods={"GET", "POST"})
     */
    public function index(EventRepository $eventRepository, Request $request): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventRepository->add($event, true);

            return $this->redirectToRoute('admin_concert_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/concert/index.html.twig', [
            'events' => $eventRepository->findAll(),
            'form' => $form->createView(),
            'current_menu' => 'admin'

        ]);
    }

    /**
     * @Route("/new", name="admin_concert_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EventRepository $eventRepository): Response
    {
        $event = new Event();
        $form = $this->createForm(Event1Type::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventRepository->add($event, true);

            return $this->redirectToRoute('admin_concert_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/concert/new.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_concert_show", methods={"GET"})
     */
    public function show(Event $event): Response
    {
        return $this->render('admin/concert/show.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_concert_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Event $event, EventRepository $eventRepository): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventRepository->add($event, true);

            return $this->redirectToRoute('admin_concert_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/concert/edit.html.twig', [
            'event' => $event,
            'form' => $form,
            'current_menu' => 'admin'

        ]);
    }

    /**
     * @Route("/{id}", name="admin_concert_delete", methods={"POST"})
     */
    public function delete(Request $request, Event $event, EventRepository $eventRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $event->getId(), $request->request->get('_token'))) {
            $eventRepository->remove($event, true);
        }

        return $this->redirectToRoute('admin_concert_index', [], Response::HTTP_SEE_OTHER);
    }
}
