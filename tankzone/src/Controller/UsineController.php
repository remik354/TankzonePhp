<?php

namespace App\Controller;

use App\Entity\Usine;
use App\Form\UsineType;
use App\Repository\UsineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

    #[Route('/{id}', name: 'app_usine_show', methods: ['GET'])]
    public function show(Usine $usine): Response
    {
        return $this->render('usine/show.html.twig', [
            'usine' => $usine,
        ]);
    }

    #[Route('/tank/{id}', name: 'app_usine_tank_show', methods: ['GET'])]
    public function show_tank(Usine $usine): Response
    {
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
