<?php


namespace App\Exam\Application;

use App\Entity\Question as QuestionEntity;
use App\Exam\Domain\ApplicationId;
use App\Exam\Domain\Exceptions\ExamsForApplicationIdNotFound;
use App\Exam\Domain\Exceptions\QuestionsForAplicationIdNotFound;
use App\Exam\Domain\Question;
use App\Exam\Domain\Repository\ExamRepository;
use App\Exam\Domain\Repository\QuestionRepository;

class RamdomQuestionFinder
{

    private QuestionRepository $questionRepository;
    private ExamRepository $examRepository;

    public function __construct(
        ExamRepository $examRepository,
        QuestionRepository $questionRepository
    )
    {
        $this->questionRepository = $questionRepository;
        $this->examRepository = $examRepository;
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