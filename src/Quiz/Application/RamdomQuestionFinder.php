<?php


namespace App\Quiz\Application;

use App\Entity\Question as QuestionEntity;
use App\Quiz\Domain\ApplicationId;
use App\Quiz\Domain\Exceptions\ExamsForApplicationIdNotFound;
use App\Quiz\Domain\Exceptions\QuestionsForAplicationIdNotFound;
use App\Quiz\Domain\Question;
use App\Quiz\Domain\Repository\ExamRepository;
use App\Quiz\Domain\Repository\QuestionRepository;

class RamdomQuestionFinder
{
    public function __construct(
        private readonly ExamRepository $examRepository,
    )
    {
    }

    /**
     * @throws QuestionsForAplicationIdNotFound
     */
    public function __invoke(ApplicationId $applicationId, array $previousAnsweredQuestions):Question
    {

        $questions = $this->examRepository->findRandomQuestions($applicationId);

        shuffle($questions);

        while (count($questions) > 0) {
            $questionIndex = rand(0, count($questions)-1);
            $question = $questions[$questionIndex];
            if ($question instanceof QuestionEntity) {
                $response = new Question(
                    $question->getExam()->getId(),
                    $question->getId(),
                    $question->getExamName(),
                    $question->getNumber(),
                    $question->getQuestion(),
                    $question->getA(),
                    $question->getB(),
                    $question->getC(),
                    $question->getD(),
                    $question->getAnswer(),
                    $question->getDetailedAnswer(),
                    $question->getExam()->getName(),
                    $question->getExam()->getType(),
                    $question->getExam()->getUrl(),
                    $question->getExam()->getDescription()
                );
                if (!in_array($response->getUniqueId(), $previousAnsweredQuestions)) {
                    return $response;
                }
                unset($questions[$questionIndex]);
            }
        }

        throw new QuestionsForAplicationIdNotFound($applicationId);

    }

}