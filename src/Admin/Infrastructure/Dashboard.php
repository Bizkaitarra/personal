<?php

namespace App\Admin\Infrastructure;

use App\Entity\Exam;
use App\Entity\Question;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard as EasyAdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

class Dashboard extends AbstractDashboardController
{

    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): EasyAdminDashboard
    {
        return EasyAdminDashboard::new()
            ->setTitle('Personal');
    }

    public function configureMenuItems(): iterable
    {

        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
         yield MenuItem::linkToCrud('Exams', 'fas fa-question-circle', Exam::class);
         yield MenuItem::linkToCrud('Questions', 'fas fa-question', Question::class);
    }
}
