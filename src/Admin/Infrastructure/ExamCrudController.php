<?php

namespace App\Admin\Infrastructure;

use App\Entity\Exam;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class ExamCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Exam::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnForms(),
            BooleanField::new('state'),
            TextField::new('name'),
            TextField::new('description'),
            UrlField::new('url'),
            TextField::new('type'),
            IntegerField::new('application'),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('state')
            ->add('type')
            ->add('application')
            ;
    }

}
