<?php

namespace App\Exam\Domain\Repository;

use App\Entity\AnsweredQuestion;

interface AnsweredQuestionRepository
{
    public function save(AnsweredQuestion $answeredQuestion):void;
}