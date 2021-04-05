<?php


namespace App\Exam\Application;


use App\Exam\Domain\ApplicationId;
use App\Exam\Domain\Exceptions\ExamsForApplicationIdNotFound;
use App\Exam\Domain\Exceptions\QuestionsForAplicationIdNotFound;
use App\Exam\Domain\Question;
use App\Exam\Domain\Repository\QuestionRepository;

class RamdomQuestionFinder
{

    private QuestionRepository $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    /**
     * @param ApplicationId $applicationId
     * @return Question
     * @throws ExamsForApplicationIdNotFound
     * @throws QuestionsForAplicationIdNotFound
     */
    public function __invoke(ApplicationId $applicationId):Question
    {
        return $this->questionRepository->findRamdomQuestion($applicationId);
    }

}