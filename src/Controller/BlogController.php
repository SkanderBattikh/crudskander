<?php

namespace App\Controller;

use App\Entity\Employes;
use App\Form\EmployesType;
use App\Repository\EmployesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    #[Route('/Accueil', name: 'acceuil')]
    public function index(): Response
    {
        return $this->render('employes/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    #[Route('/', name: 'home')]
    public function home() {
        return $this->render('employes/home.html.twig');
    }

    #[Route('/employes', name: 'liste_employes')]
    public function liste(EmployesRepository $repo) 
    {
        $employes = $repo->findAll();
     
        return $this->render('employes/liste.html.twig', [
            'employes'=> $employes
        ]);
    }
    #[Route('/ajouter/employes', name:'ajoute_employes')]
    #[Route('employes/edit/{id}', name:"employes_edit")]
    public function form(Request $globals, EntityManagerInterface $manager, Employes $employes = null)
    
    {
        if($employes == null){
        $employes = new Employes;
        }
        $form =$this->createForm(EmployesType::class, $employes);

        $form->handleRequest($globals);
        if($form->isSubmitted() && $form->isValid())
        {
            
            $manager->persist($employes); 
            $manager->flush(); 

            return $this->redirectToRoute('liste_employes');
            
        }

        return $this->renderForm('employes/form.html.twig', [
            'formEmployes' => $form,
            'editMode' => $employes->getId() !== NULL
   
        ]);  
    }

    #[Route('/supprimer/employes/{id}', name:"employes_delete")]
        public function delete($id,EntityManagerInterface $manager, EmployesRepository $repo)
        {
            $employe = $repo->find($id);

            $manager->remove($employe); //préparé
            $manager->flush(); // exécuter
            
            return $this->redirectToRoute('liste_employes'); //redirection
        }


}
