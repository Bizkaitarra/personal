<?php

namespace App\SchoolMenu\Infrastructure\Repository;

use App\Entity\DayMenu;
use App\SchoolMenu\Domain\AlexaMenuDay;
use App\SchoolMenu\Domain\Repository\MenuRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineMenuRepository implements MenuRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getLastDayWithMenu(): ?DateTime
    {
        $dayMenu = $this->entityManager->getRepository(DayMenu::class)->findOneBy([],['day'=>'desc']);

        if (!$dayMenu instanceof DayMenu) {
            return null;
        }

        return $dayMenu->getDay();
    }

    public function getMenusAfterDate(DateTime $date, int $limit): ?array
    {
        $qb = $this->entityManager->createQueryBuilder();

        $q  = $qb->select('d')
            ->from(DayMenu::class, 'd')
            ->andWhere(
                'd.day >= :date',
            )
            ->setParameter('date', $date)
            ->orderBy('d.day', 'ASC')
            ->setMaxResults($limit)
            ->getQuery();

        $data = $q->getResult();
        $result = [];

        foreach ($data as $menuItem) {
            $result[] = AlexaMenuDay::fromDayMenu(
                $menuItem
            );
        }

        return $result;

    }
}
