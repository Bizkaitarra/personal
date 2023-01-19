<?php


namespace App\Quiz\Domain\Repository;




use App\Entity\Exam;
use App\Entity\Question;
use App\Quiz\Domain\Exceptions\QuestionNotFound;

interface QuestionRepository
{
    public function findRamdomQuestion(Exam $exam):?Question;
    /**
     * @throws QuestionNotFound
     */
    public function find(int $questionId):Question;
}