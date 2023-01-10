<?php


namespace App\Exam\Domain\Repository;




use App\Entity\Exam;
use App\Entity\Question;

interface QuestionRepository
{
    public function findRamdomQuestion(Exam $exam):?Question;
}