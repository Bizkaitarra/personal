<?php


namespace App\Exam\Infrastructure\Repository;


use App\Entity\Exam;
use App\Exam\Domain\ApplicationId;
use App\Exam\Domain\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Question;

class DoctrineQuestionRepository implements QuestionRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function findRandomQuestion(Exam $exam):?Question
    {
        $questions = $this->entityManager->getRepository(Question::class)->findBy(
            ['exam'=>$exam]
        );

        if (count($questions) === 0) {
            return null;
        }

        shuffle($questions);

        return $questions[0];
    }

    /**
     * @inheritDoc
     */
    public function findRandomQuestions(ApplicationId $applicationId, int $numberOfQuestions):? array
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('q');
        $qb->from(Question::class, 'q');
        $qb->innerJoin('q.exam', 'e');
        $qb->where('e.application = :applicationId');
        $qb->setParameter(':applicationId', $applicationId->value());
        $questions = $qb->getQuery()->getResult();


        if (count($questions) == 0) {
            return [];
        }

        shuffle($questions);

        return array_slice($questions, 0, $numberOfQuestions);
    }
}