<?php


namespace App\Exam\Infrastructure\Repository;


use App\Entity\Exam;
use App\Exam\Domain\ApplicationId;

use App\Exam\Domain\Exceptions\ExamsForApplicationIdNotFound;
use App\Exam\Domain\Exceptions\QuestionsForAplicationIdNotFound;
use App\Exam\Domain\Question;
use App\Exam\Domain\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Question as QuestionEntity;

class DoctrineQuestionRepository implements QuestionRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @param ApplicationId $applicationId
     * @return Question
     * @throws ExamsForApplicationIdNotFound
     * @throws QuestionsForAplicationIdNotFound
     */
    public function findRamdomQuestion(ApplicationId $applicationId): Question
    {

        $exams = $this->entityManager->getRepository(Exam::class)->findBy(
            ['application'=>$applicationId->value()]
        );

        if (count($exams) === 0) {
            throw new ExamsForApplicationIdNotFound($applicationId);
        }

        shuffle($exams);

        foreach ($exams as $exam) {
            $questions = $this->entityManager->getRepository(QuestionEntity::class)->findBy(
                ['exam'=>$exam]
            );

            if (count($questions) === 0) {
                continue;
            }

            shuffle($questions);

            /** @var QuestionEntity $question */
            $question = $questions[0];
            return new Question(
                $question->getExamName(),
                $question->getNumber(),
                $question->getQuestion(),
                $question->getA(),
                $question->getB(),
                $question->getC(),
                $question->getD(),
                $question->getAnswer()
            );
        }

        throw new QuestionsForAplicationIdNotFound($applicationId);

    }
}