<?php


namespace App\Exam\Domain\Repository;




use App\Exam\Domain\ApplicationId;
use App\Exam\Domain\Exceptions\ExamsForApplicationIdNotFound;
use App\Exam\Domain\Exceptions\QuestionsForAplicationIdNotFound;
use App\Exam\Domain\Question;

interface QuestionRepository
{
    /**
     * @param ApplicationId $applicationId
     * @return Question
     * @throws ExamsForApplicationIdNotFound
     * @throws QuestionsForAplicationIdNotFound
     */
    public function findRamdomQuestion(ApplicationId $applicationId):Question;
}