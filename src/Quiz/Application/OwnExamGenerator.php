<?php

namespace App\Quiz\Application;

use App\Quiz\Domain\ApplicationId;
use App\Quiz\Domain\Repository\ExamRepository;

class OwnExamGenerator
{
    public function __construct(
        private readonly ExamRepository $examRepository,
        private readonly ExamGenerator $examGenerator
    )
    {
    }

    public function __invoke(OwnExamRequest $ownExamRequest): string
    {
        $questions = [];
        /** @var OwnExam $exam */
        foreach ($ownExamRequest->exams() as $exam) {
            $examQuestions = $this->examRepository->findRandomQuestionsForExam($exam->examId);
            shuffle($examQuestions);
            $examQuestions = array_slice($examQuestions, 0,$exam->numberOfQuestions);
            $questions = array_merge(
                $questions,
                $examQuestions
            );
        }
        shuffle($questions);
        return $this->examGenerator->__invoke(
            $questions,
            false,
            false
        );
    }


}