<?php

namespace App\Controller;

use App\Entity\Tank;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/tank')]
class TankController extends AbstractController
{

//     #[Route('/', name: 'home', methods: ['GET'])]
//     public function indexAction(): Response
//     {
//         return $this->render('index.html.twig', [
//             'welcome' => 'Voici tous les tanks disponibles',
//         ]);
//     }

    #[Route('/{id}', name: 'tank_show', requirements: ['id' => '\d+'])]
    public function show(ManagerRegistry $doctrine, $id)
    {
            $tankRepo = $doctrine->getRepository(Tank::class);
            $tank = $tankRepo->find($id);

            if (!$tank) {
                    throw $this->createNotFoundException('The tank does not exist');
            }
            
            return $this->render('tank/show.html.twig',
            [ 'tank' => $tank ]
            );

    }
}

