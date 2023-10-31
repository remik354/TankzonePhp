<?php

namespace App\Controller\Admin;
use App\Entity\Garage;
use App\Entity\Member;
use App\Entity\Tank;
use App\Entity\Usine;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(GarageCrudController::class)->generateUrl();
        return $this->redirect($url);}
       

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Tankzone');
    }
    
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Members', 'fas fa-list', Member::class);
        yield MenuItem::linkToCrud('Garages', 'fas fa-list', Garage::class);
        yield MenuItem::linkToCrud('Tanks', 'fas fa-list', Tank::class);
        yield MenuItem::linkToCrud('Usine', 'fas fa-list', Usine::class);

    }
}
