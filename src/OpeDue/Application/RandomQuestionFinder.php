<?php


namespace App\OpeDue\Application;


use App\Entity\Question;
use App\Exam\Domain\ApplicationId;
use App\Exam\Domain\Exceptions\ExamsForApplicationIdNotFound;
use App\Exam\Domain\Exceptions\QuestionsForAplicationIdNotFound;
use App\Exam\Domain\Repository\ExamRepository;
use App\Exam\Domain\Repository\QuestionRepository;

class RandomQuestionFinder
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
    public function __invoke(
        ApplicationId $applicationId
    ):Question
    {

        $exams = $this->examRepository->findByApplication($applicationId);

        if (count($exams) === 0) {
            throw new ExamsForApplicationIdNotFound($applicationId);
        }

        shuffle($exams);

        foreach ($exams as $exam) {

            $question = $this->questionRepository->findRamdomQuestion($exam);
            if  ($question instanceof Question) {
                return $question;
            }
        }

        throw new QuestionsForAplicationIdNotFound($applicationId);

    }
}