<?php

namespace App\Admin\Infrastructure;

use App\Entity\CMSUser;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class CMSUserCrud extends AbstractCrudController
{
    private CMSUser $user;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        if ($tokenStorage->getToken() instanceof TokenInterface && $tokenStorage->getToken()->getUser() instanceof CMSUser) {
            $this->user = $tokenStorage->getToken()->getUser();
        }
    }

    public static function getEntityFqcn(): string
    {
        return CMSUser::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields[] = EmailField::new('email', 'E-mail');
        $userRoleChoices = [
            'Administrador' => 'ROLE_ADMIN',
            'Gestor' => 'ROLE_MANAGER',
            'Usuario de Quiz' => 'ROLE_QUIZ_USER',
        ];
        if ($this->user->hasRole('ROLE_SUPER_ADMIN') || Crud::PAGE_INDEX === $pageName) {
            $userRoleChoices['SuperAdministrador'] = 'ROLE_SUPER_ADMIN';
        }
        $fields[] = ChoiceField::new('roles', 'Rol(es)')->setChoices($userRoleChoices)
            ->allowMultipleChoices(true);
        $fields[] = TextField::new('name','Nombre');
        $fields[] = BooleanField::new('changePassword', 'Cambio contraseña')->onlyWhenUpdating();
        $fields[] = TextField::new('password', 'Contraseña')->onlyOnForms();

        return $fields;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud = parent::configureCrud($crud);

        return $crud
            ->setEntityLabelInSingular('User')
            ->setEntityLabelInPlural('Users');
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions = parent::configureActions($actions);

        return $actions->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
            return $action->setLabel('Editar');
        });
    }
}
