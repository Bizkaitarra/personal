<?php

namespace App\Admin\Infrastructure;

use App\Entity\DayMenu;
use App\SchoolMenu\Domain\Repository\MenuRepository;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DayMenuCrudController extends AbstractCrudController
{


    private MenuRepository $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    public static function getEntityFqcn(): string
    {
        return DayMenu::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            DateField::new('day', 'Día')->setFormat('Y-M-d'),
            TextField::new('first', 'Primer plato'),
            TextField::new('second', 'Segundo plato'),
            TextField::new('dessert', 'Postre'),
        ];
    }
    public function createEntity(string $entityFqcn) {


        $dayMenu = new DayMenu();
        $dayMenu->setDay($this->getDefaultMenuDay());
        $dayMenu->setDessert('Fruta');
        return $dayMenu;
    }

    private function getDefaultMenuDay(): DateTime
    {
        $lastMenuDay = $this->menuRepository->getLastDayWithMenu();
        if ($lastMenuDay === null) {
            return new DateTime();
        }
        $lastMenuDay->modify('+1 day');

        while ($this->isSaturdayOrSunday($lastMenuDay)) {
            $lastMenuDay->modify('+1 day');
        }

        return $lastMenuDay;
    }

    /**
     * @param DateTime $lastMenuDay
     * @return bool
     */
    private function isSaturdayOrSunday(DateTime $lastMenuDay): bool
    {
        return in_array($lastMenuDay->format('N'), [6, 7]);
    }

}
