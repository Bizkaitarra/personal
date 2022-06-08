<?php


namespace App\Exam\Domain\Repository;




use App\Entity\Exam;
use App\Entity\Question;
use App\Exam\Domain\ApplicationId;

interface QuestionRepository
{
    public function findRandomQuestion(Exam $exam):?Question;

    /**
     * @param ApplicationId $applicationId
     * @param int $numberOfQuestions
     * @return Question[]|null
     */
    public function findRandomQuestions(ApplicationId $applicationId, int $numberOfQuestions):? array;

    public function find(int $id):Question;
}