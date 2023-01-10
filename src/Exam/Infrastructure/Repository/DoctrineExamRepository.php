<?php


namespace App\Exam\Infrastructure\Repository;


use App\Entity\Exam;
use App\Entity\Question;
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

    public function findRandomQuestions(ApplicationId $applicationId): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $query = $queryBuilder
            ->select('q')
            ->from(Question::class, 'q')
            ->join('q.exam', 'e')
            ->andWhere('e.application = :application')
            ->andWhere('e.state = 1')
            ->andWhere('q.state = 1')
            ->setParameter('application', $applicationId->value())
            ->getQuery();

        return $query->getResult();

    }
}