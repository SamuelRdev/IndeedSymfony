<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Repository\OfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route('/', name: 'offers.list')]
    public function index(OfferRepository $repo): Response
    {
        $offer_list = $repo->findAll();

        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
            "offer_list" => $offer_list
        ]);
    }

    #[Route('/offers/{id}', name: 'offers.show')]
    public function show(OfferRepository $repo, Request $request, Offer $offer)
    {
        return $this->render('app/offer.html.twig', [
            "offer" => $offer
        ]);
    }
}
