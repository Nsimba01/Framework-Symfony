<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use  App\Repository\AtelierRepository;

use Symfony\Component\HttpFoundation\Request;

use Doctrine\Persistence\ManagerRegistry;


use App\Entity\Atelier;

use App\Form\AtelierType; 



class AtelierController extends AbstractController
{
    #[Route('/atelier', name: 'app_first')]
    public function index(AtelierRepository $atelierRepositor): Response
    {
		
		
		
        return $this->render('atelier/index.html.twig',[
            'ateliers' =>$atelierRepositor->findAll(),
        ]);

    }
	
	 #[Route('/add', name: 'add_atelier')]
    public function add(Request $request,ManagerRegistry $doctrine)
    {
		
	  $atelier = new Atelier();
      $form = $this->createForm(AtelierType::class, $atelier);
      $form->handleRequest($request);
	  
	   if ($form->isSubmitted() && $form->isValid()) {
		   
		     $em = $doctrine->getManager();
			 $em->persist($atelier);
             $em->flush();
			 $this->addFlash('success', 'Atelier correctement enregistrée !');
             
			 return $this->redirectToRoute('app_first'); // Route qui affiche les ateliers
       }
		
		
	  return $this->render('atelier/add.html.twig', [
     'formAtelier' => $form->createView()
   ]);
	
	}
	
   #[Route('/update/{atelier_id}', name: 'update_atelier')]
   
    public function update(AtelierRepository $atelierRepositor,Request $request,
	ManagerRegistry $doctrine): Response
    {
		 $atelier = new Atelier();
		 $form = $this->createForm(AtelierType::class, $atelier);
         $form->handleRequest($request);
		 
		 $routeParams = $request->attributes->get('_route_params');
		 
		 $id=$routeParams['atelier_id'];

		
		 
		 /*  EN CAS DE NON ENVOIE DE FORMULAIRE ET QUE CETTE VARIABLE EST RENSEIGNEE DANS LA VUE 
  */
		 $data_name=null;
		 
		 $data_description=null;
		 
		 if ($form->isSubmitted() && $form->isValid()) {
			 
			 
			 // TO GET THE VALUES OF FORM 
			 
			 // Nom et Description sont les names de input voir AtelierType php
			 
			 $data_name=$form->get('Nom')->getData();

			 
			 $data_description=$form->get('Description')->getData();
		
			 
			  $entityManager = $doctrine->getManager();
			  $atelier_save = $entityManager->getRepository(Atelier::class)->find($id);
		 
		    
           
		   
		        $atelier_save->setNom($data_name);
				$atelier_save->setDescription($data_description);
                $entityManager->flush();
            

               // Re-direction vers l'affichage des ateliers pour voir 
			   // la modification le update de l'atelier
			   
			   return $this->redirectToRoute('app_first'); //app_first,
			   // le name de route /atelier


     
			 
			 
			 
			 
		 }


		
        return $this->render('atelier/update.html.twig',[
            'ateliers' =>$atelierRepositor->findAll(),
			'atelier_id'=>$routeParams['atelier_id'],
			'formAtelier' => $form->createView(),
			'data_name'=>$data_name,
			'data_description'=>$data_description,
        ]);

    }
	
	
	 #[Route('/delete/{id_delete}', name: 'delete_atelier')]
    public function delete(AtelierRepository $atelierRepositor,Request $request,
	ManagerRegistry $doctrine): Response
    {
		
		 $routeParams = $request->attributes->get('_route_params');
		 
		 $id=$routeParams['id_delete'];
		 
		 $entityManager = $doctrine->getManager();
		 
		 $atelier_delete = $entityManager->getRepository(Atelier::class)->find($id);
		 
		 $entityManager->remove($atelier_delete);
		 
		 $entityManager->flush();


		
		
       return $this->redirectToRoute('app_first'); //app_first,
			   // le name de route /atelier

    }

}
