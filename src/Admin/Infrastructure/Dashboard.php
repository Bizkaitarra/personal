<?php

namespace App\Admin\Infrastructure;

use App\Entity\AnsweredQuestion;
use App\Entity\CMSUser;
use App\Entity\DayMenu;
use App\Entity\Exam;
use App\Entity\Question;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard as EasyAdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

class Dashboard extends AbstractDashboardController
{
    public function __construct(
        private readonly AdminUrlGenerator $adminUrlGenerator
    )
    {}


    public function index(): Response
    {
        return $this->redirect($this->adminUrlGenerator->setController(ExamCrudController::class)->generateUrl());
    }

    public function configureDashboard(): EasyAdminDashboard
    {
        return EasyAdminDashboard::new()
            ->setTitle('Personal');
    }

    public function configureMenuItems(): iterable
    {
        return
            [
                MenuItem::linktoDashboard('Dashboard', 'fa fa-home'),
                MenuItem::linkToCrud('Exams', 'fas fa-question-circle', Exam::class),
                MenuItem::linkToCrud('Questions', 'fas fa-question', Question::class),
                MenuItem::linkToCrud('Answered Questions', 'fas fa-question', AnsweredQuestion::class),
                MenuItem::linkToCrud('Menú', 'fas fa-utensils', DayMenu::class),
                MenuItem::linkToCrud('Usuarios de CMS', 'fas fa-users-cog', CMSUser::class)
                    ->setPermission('ROLE_ADMIN'),
            ];
    }
}
