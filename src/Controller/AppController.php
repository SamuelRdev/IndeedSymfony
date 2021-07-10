<?php

namespace App\Controller;
use App\Entity\Offer;
use App\Form\OfferType;
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


    #[Route('/offers/add', name: 'offers.create')]
    #[Route('/offers/{id}/edit', name: 'offers_edit.create')]
    public function form(Offer $offer = null, Request $request)
    {
        if(!$offer)
        {
            $offer = new Offer();
        }

        $form = $this->createForm(OfferType::class, $offer);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            if(!$offer->getId())
            {
                $offer->setCreatedAt(new \DateTime());
            } else
            {
                $offer->setUpdatedAt(new \DateTime());
            }

            $offer = $form->getData();

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($offer);
            $manager->flush();

            
            return $this->redirectToRoute("offers.show", ['id' => $offer->getId()]);
        }

        return $this->render("app/create.html.twig", [
            "form" => $form->createView(),
            'editMode' => $offer->getId() !== null
        ]);

    }

    #[Route('/offers/{id}', name: 'offers.show')]
    public function show(OfferRepository $repo, Request $request, Offer $offer)
    {
        return $this->render('app/offer.html.twig', [
            "offer" => $offer
        ]);
    }

     
    #[Route('/offers/delete/{id}', name: 'offers.delete')]
    public function delete(Offer $offer) 
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($offer);
        $manager->flush();

        return $this->render("delete_offer/delete.html.twig");
    }
    
}
