<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Entity\ContractType;
use App\Entity\User;
use App\Form\CategoryType;
use App\Form\ContractTypeType;
use App\Form\EditUserType;
use App\Repository\ContractRepository;
use App\Repository\ContractTypeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function usersList(UserRepository $usersRepo, ContractRepository $contractRepo, ContractTypeRepository $contractTypeRepo)
    {
        $contractList = $contractRepo->findAll();
        $contractTypeList = $contractTypeRepo->findAll();
        $usersList =  $usersRepo->findAll();

        return $this->render('admin/index.html.twig', [
            "contractList" => $contractList,
            "contractTypeList" => $contractTypeList,
            "usersList" => $usersList
        ]);
    }

    #[Route('/contracts/create', name: 'contracts.create')]
    #[Route('/contracts/{id}/update', name: 'contracts.update')]
    public function formContract(Request $request, Contract $contract = null)
    {
        if(!$contract)
        {
            $contract = new Contract();
            $editMode = false;
        } else
        {
            $editMode = true;
        }

        $form = $this->createForm(CategoryType::class, $contract);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $contract = $form->getData();

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($contract);
            $manager->flush();

            $this->addFlash('message', 'Contrat ajouté/modifié avec succès.');

            return $this->redirectToRoute("admin_index");
           
        }

        return $this->render('admin/contract.html.twig', [
            'form' => $form->createView(),
            'editMode' => $editMode
        ]);
    }

    #[Route('/contracts/delete/{id}', name: 'contracts.delete')]
    public function deleteContract(Contract $contract) 
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($contract);
        $manager->flush();

        $this->addFlash('message', 'Contrat supprimé avec succès.');

        return $this->redirectToRoute('admin_index');
    }

    
    #[Route('/contract_types/create', name: 'contract_types.create')]
    #[Route('/contract_types/{id}/update', name: 'contract_types.update')]

    public function formContractType(Request $request, ContractType $contractType = null)
    {

        if(!$contractType)
        {
            $editMode = false;
            $contractType = new ContractType();
        }else
        {
            $editMode = true;
        }

        $form = $this->createForm(ContractTypeType::class, $contractType);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $contractType = $form->getData();

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($contractType);
            $manager->flush();


            $this->addFlash('message', 'Type de contrat ajouté/modifié avec succès.');

            return $this->redirectToRoute("admin_index");
           
        }

        return $this->render('admin/contractType.html.twig', [
            'form' => $form->createView(),
            'editMode' => $editMode
        ]);
    }

    #[Route('/contract_types/delete/{id}', name: 'contract_types.delete')]
    public function deleteContractType(ContractType $contractType) 
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($contractType);
        $manager->flush();

        $this->addFlash('message', 'Type de contrat supprimé avec succès.');

        return $this->redirectToRoute('admin_index');
    }

    #[Route('/users/update/{id}', name: 'users.update')]
    public function editUser(Request $request, User $user)
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('message', 'Utilisateur modifié avec succès');

            return $this->redirectToRoute('admin_index');
        }
        return $this->render('admin/edituser.html.twig', [
            'userForm' => $form->createView()
        ]);
    }
}
