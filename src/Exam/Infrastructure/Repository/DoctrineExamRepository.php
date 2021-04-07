<?php


namespace App\Exam\Infrastructure\Repository;


use App\Entity\Exam;
use App\Exam\Domain\ApplicationId;
use App\Exam\Domain\Repository\ExamRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineExamRepository implements ExamRepository
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findByApplication(ApplicationId $applicationId): array
    {
        return $this->entityManager->getRepository(Exam::class)->findBy(
            ['application'=>$applicationId->value()]
        );

    }
}