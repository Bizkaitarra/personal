<?php


namespace App\Quiz\Infrastructure\Repository;


use App\Entity\Exam;
use App\Quiz\Domain\Exceptions\QuestionNotFound;
use App\Quiz\Domain\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Question;

class DoctrineQuestionRepository implements QuestionRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function findRamdomQuestion(Exam $exam):?Question
    {

        $questions = $this->entityManager->getRepository(Question::class)->findBy(
            [
                'exam'=>$exam,
                'state' => 1
            ]
        );
        if (count($questions) == 0) {
            return null;
        }

        shuffle($questions);

        return $questions[0];
    }

    /**
     * @throws QuestionNotFound
     */
    public function find(int $questionId): Question
    {
        $question = $this->entityManager->getRepository(Question::class)->find($questionId);

        if (!$question instanceof Question) {
            throw new QuestionNotFound($questionId);
        }
        return $question;
    }

}