<?php

namespace App\Controller;

use App\Entity\Garage;
use App\Entity\Member;
use App\Entity\Usine;

use App\Form\GarageType;
use App\Form\UsineType;

use App\Repository\GarageRepository;
use App\Repository\UsineRepository;
use App\Repository\MemberRepository;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;



#[Route('/member')]
class MemberController extends AbstractController
{
    #[Route('/index', name: 'app_member_index', methods: ['GET'])]
    public function index(MemberRepository $memberRepository): Response
    {
        return $this->render('member/index.html.twig', [
            'members' => $memberRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'member_show', requirements: ['id' => '\d+'])]
    public function show(ManagerRegistry $doctrine, $id)
    {
            $memberRepo = $doctrine->getRepository(Member::class);
            $member = $memberRepo->find($id);

            if (!$member) {
                    throw $this->createNotFoundException('The member does not exist');
            }

            return  $this->render('member/show.html.twig',
                    [ 'member' => $member ]
                    );
    }

    /**
     * @param("member", options={"id" = "member_id"})
     * @param("garage", options={"id" = "garage_id"})
     */

     #[Route('/{member_id}/garage/{garage_id}', name: 'app_member_garage_show', methods: ['GET'])]
     public function show_garage(ManagerRegistry $doctrine, $member_id, $garage_id): Response
     {
         $garageRepo = $doctrine->getRepository(Garage::class);
         $garage = $garageRepo->find($garage_id);
         $memberRepo = $doctrine->getRepository(Member::class);
         $member = $memberRepo->find($member_id);
     {
         return $this->render('member/garage_show.html.twig',   [
             'garage' => $garage,
             'member' => $member
         ]);
     }
     }

         /**
     * @param("member", options={"id" = "member_id"})
     * @param("usine", options={"id" = "usine_id"})
     */

     #[Route('/{member_id}/usine/{usine_id}', name: 'app_member_usine_show', methods: ['GET'])]
     public function show_usine(ManagerRegistry $doctrine, $member_id, $usine_id, Security $security): Response
     {
         $usineRepo = $doctrine->getRepository(Usine::class);
         $usine = $usineRepo->find($usine_id);
         $memberRepo = $doctrine->getRepository(Member::class);
         $member = $memberRepo->find($member_id);

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
     {
         return $this->render('member/usine_show.html.twig',   [
             'usine' => $usine,
             'member' => $member
         ]);
     }
     }
}
