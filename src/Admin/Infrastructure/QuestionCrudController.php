<?php

namespace App\Admin\Infrastructure;

use App\Entity\Question;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class QuestionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Question::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnForms(),
            BooleanField::new('state'),
            AssociationField::new('exam'),
            IntegerField::new('number'),
            TextField::new('question'),
            TextField::new('a')->onlyOnForms(),
            TextField::new('b')->onlyOnForms(),
            TextField::new('c')->onlyOnForms(),
            TextField::new('d')->onlyOnForms(),
            TextField::new('answer'),
            TextField::new('detailedAnswer'),
            IntegerField::new('application'),

        ];
    }
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('exam')
            ->add('question')
            ->add('a')
            ->add('b')
            ->add('c')
            ->add('d')
            ->add('answer')
            ->add('detailedAnswer')
            ;
    }

}
