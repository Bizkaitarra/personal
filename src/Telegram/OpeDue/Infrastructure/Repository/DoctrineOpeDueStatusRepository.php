<?php


namespace App\Telegram\OpeDue\Infrastructure\Repository;


use App\Entity\OpeDueChatStatus;
use App\Telegram\OpeDue\Domain\Repository\OpeDueStatusRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineOpeDueStatusRepository implements OpeDueStatusRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function save(OpeDueChatStatus $opeDueChatStatus): void
    {
        $this->entityManager->persist($opeDueChatStatus);
        $this->entityManager->flush();
    }
}