<?php

namespace App\Quiz\Application;

final class OwnExamRequest
{
    private array $exams = [];
    public function addExam(int $examId, int $numberOfQuestions) {
        $this->exams[] = new OwnExam($examId, $numberOfQuestions);
    }

    /**
     * @return OwnExam[]
     */
    public function exams(): array
    {
        return $this->exams;
    }
}