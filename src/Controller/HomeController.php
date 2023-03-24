<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\EventSearch;
use App\Form\EventSearchType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $entityManager = $managerRegistry->getManager();
        $events = [];

        $search = new EventSearch();
        $eventSearchForm = $this->createForm(EventSearchType::class, $search);

        $eventSearchForm->handleRequest($request);
        if ($eventSearchForm->isSubmitted() && $eventSearchForm->isValid()) {
            $searchInput = $eventSearchForm->getData();
            $events = $entityManager->getRepository(Event::class)->findSpecicEvent($searchInput);

            return $this->render('home/index.html.twig', [
                'title' => 'Resultat de votre recherche :',
                'events' => $events,
                'eventSearchForm' => $eventSearchForm->createView()
            ]);
        }


        $events = $entityManager->getRepository(Event::class)->findThreeMonthEvent();

        return $this->render('home/index.html.twig', [
            'title' => 'Prochains évènements ( 3 prochains mois ) :',
            'events' => $events,
            'eventSearchForm' => $eventSearchForm->createView(),
            'current_menu' => 'accueil'
        ]);
    }
}
