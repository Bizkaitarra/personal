<?php

namespace App\Quiz\Application;

final class OwnExam
{
    public function __construct(
        public readonly int $examId,
        public readonly int $numberOfQuestions
    )
    {
    }

}