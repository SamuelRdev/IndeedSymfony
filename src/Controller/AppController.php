<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Repository\OfferRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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

    #[Route('/offers/add', name: 'offers.create')]
    public function create(Request $request)
    {
        $offer = new Offer();

        $formBuilder = $this->createFormBuilder($offer);
        $formBuilder 
                    ->add('title')
                    ->add('content')
                    ->add('submit', SubmitType::class );
        $form = $formBuilder->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $offer = $form->getData();

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($offer);
            $manager->flush();

            
            return $this->redirectToRoute("offers.list");
        }

        // dd($form);


        return $this->render("app/create.html.twig", [
            "form" => $form->createView()
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
