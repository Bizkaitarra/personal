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
     * @param ApplicationId $applicationId
     * @return Question
     * @throws ExamsForApplicationIdNotFound
     * @throws QuestionsForAplicationIdNotFound
     */
    public function __invoke(ApplicationId $applicationId):Question
    {

        $exams = $this->examRepository->findByApplication($applicationId);

        if (count($exams) === 0) {
            throw new ExamsForApplicationIdNotFound($applicationId);
        }

        shuffle($exams);

        foreach ($exams as $exam) {

            $question = $this->questionRepository->findRandomQuestion($exam);

            if  ($question instanceof QuestionEntity) {

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

        }

        throw new QuestionsForAplicationIdNotFound($applicationId);

    }

}