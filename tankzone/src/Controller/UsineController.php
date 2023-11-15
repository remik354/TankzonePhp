<?php

namespace App\Controller;

use App\Entity\Tank;
use App\Entity\Usine;
use App\Form\UsineType;
use App\Form\TankType;
use App\Repository\UsineRepository;
use App\Repository\TankRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\Security\Core\Security;

#[Route('/usine')]
class UsineController extends AbstractController
{
    #[Route('/', name: 'app_usine_index', methods: ['GET'])]
    public function index(UsineRepository $usineRepository): Response
    {
        return $this->render('usine/index.html.twig', [
            'usines' => $usineRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_usine_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $usine = new Usine();
        $form = $this->createForm(UsineType::class, $usine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($usine);
            $entityManager->flush();

            return $this->redirectToRoute('app_usine_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('usine/new.html.twig', [
            'usine' => $usine,
            'form' => $form,
        ]);
    }
/**
     * @param("usine", options={"id" = "usine_id"})
     * @param("tank", options={"id" = "tank_id"})
     */

    #[Route('/{usine_id}/tank/{tank_id}', name: 'app_usine_tank_show', methods: ['GET'])]
    public function show_tank(ManagerRegistry $doctrine, $usine_id, $tank_id): Response
    {
        $tankRepo = $doctrine->getRepository(Tank::class);
        $tank = $tankRepo->find($tank_id);
        $usineRepo = $doctrine->getRepository(Usine::class);
        $usine = $usineRepo->find($usine_id);

        if(! $usine->getTanks()->contains($tank)) {
            throw $this->createNotFoundException("Couldn't find such a tank in this usine!");
            }

        return $this->render('usine/tank_show.html.twig',   [
            'tank' => $tank,
            'usine' => $usine
        ]);
    }
    
    #[Route('/{id}', name: 'app_usine_show', methods: ['GET'])]
    public function show(Usine $usine, Security $security): Response
    {
        // Vérifier si l'utilisateur est admin
        if ($security->isGranted('ROLE_ADMIN')) {
            // Si l'utilisateur est admin, pas besoin de vérifier la publicité de l'usine
            return $this->render('usine/show.html.twig', [
                'usine' => $usine,
            ]);
        }
    
        // Si l'utilisateur n'est pas admin, vérifier la publicité de l'usine
        if (!$usine->isPublic()) {
            throw $this->createAccessDeniedException("You cannot access the requested resource!");
        }
    
        return $this->render('usine/show.html.twig', [
            'usine' => $usine,
        ]);
    }
    

    #[Route('/{id}/edit', name: 'app_usine_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Usine $usine, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UsineType::class, $usine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_usine_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('usine/edit.html.twig', [
            'usine' => $usine,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_usine_delete', methods: ['POST'])]
    public function delete(Request $request, Usine $usine, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$usine->getId(), $request->request->get('_token'))) {
            $entityManager->remove($usine);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_usine_index', [], Response::HTTP_SEE_OTHER);
    }
}
