<?php

namespace App\Admin\Infrastructure;

use App\Entity\AnsweredQuestion;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AnsweredQuestionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AnsweredQuestion::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnForms(),
            DateTimeField::new('date'),
            AssociationField::new('user'),
            AssociationField::new('question'),
            BooleanField::new('success')->onlyOnIndex()
        ];
    }
}
