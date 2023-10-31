<?php

namespace App\Controller;

use App\Entity\Garage;
use App\Form\GarageType;
use App\Repository\GarageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;


#[Route('/garage')]
class GarageController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function indexAction(): Response
    {
        return $this->render('index.html.twig', [
            'welcome' => 'Bienvenue sur le meilleur site d\'achat et vente de tanks !',
        ]);
    }

    /**
     * Lists all todo entities.
     */
    #[Route('/list', name: 'garage_list', methods: ['GET'])]
    public function listAction(ManagerRegistry $doctrine): Response
    {
            $entityManager= $doctrine->getManager();
            $garages = $entityManager->getRepository(Garage::class)->findAll();
            return $this->render('garage/index.html.twig',
                    [ 'garages' => $garages ]
                    );
    }

    #[Route('/new', name: 'app_garage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $garage = new garage();
        $form = $this->createForm(GarageType::class, $garage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($garage);
            $entityManager->flush();

            return $this->redirectToRoute('garage_list', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('garage/new.html.twig', [
            'garage' => $garage,
            'form' => $form,
        ]);

    } 

    #[Route('/{id}', name: 'garage_show', requirements: ['id' => '\d+'])]
    public function show(ManagerRegistry $doctrine, $id)
    {
            $garageRepo = $doctrine->getRepository(garage::class);
            $garage = $garageRepo->find($id);

            if (!$garage) {
                    throw $this->createNotFoundException('The garage does not exist');
            }

            return  $this->render('garage/show.html.twig',
                    [ 'garage' => $garage ]
                    );
    }
}

