<?php

namespace App\Controller;

use App\Entity\ContractType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContractTypeController extends AbstractController
{

    #[Route('/contract_type/create', name: 'contract_type.create')]
    public function create(Request $request){
        $contractType = new ContractType();

        $formBuilder = $this->createFormBuilder($contractType);
        $formBuilder
                    ->add('name')
                    ->add('submit', SubmitType::class);

        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $contractType = $form->getData();

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($contractType);
            $manager->flush();

            return $this->redirectToRoute("offers.list");
           
        }

        return $this->render('contract_type/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
