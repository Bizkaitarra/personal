<?php


namespace App\Exam\Domain\Repository;




use App\Entity\Exam;
use App\Entity\Question;
use App\Exam\Domain\Exceptions\QuestionNotFound;

interface QuestionRepository
{
    public function findRamdomQuestion(Exam $exam):?Question;
    /**
     * @throws QuestionNotFound
     */
    public function find(int $questionId):Question;
}