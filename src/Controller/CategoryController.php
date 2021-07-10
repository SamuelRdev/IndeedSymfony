<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    
    #[Route('/categories/create', name: 'categories.create')]
    public function create(Request $request){
        $contract = new Contract();

        $form = $this->createForm(CategoryType::class, $contract);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $contract = $form->getData();

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($contract);
            $manager->flush();

            return $this->redirectToRoute("offers.list");
           
        }

        return $this->render('category/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
