<?php

namespace App\Exam\Infrastructure\Repository;

use App\Entity\AnsweredQuestion;
use App\Exam\Domain\Repository\AnsweredQuestionRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineAnsweredQuestionRepository implements AnsweredQuestionRepository
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    public function save(AnsweredQuestion $answeredQuestion): void
    {
        $this->entityManager->persist($answeredQuestion);
        $this->entityManager->flush();
    }
}