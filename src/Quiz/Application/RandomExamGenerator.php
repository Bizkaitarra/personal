<?php

namespace App\Quiz\Application;

use App\Quiz\Domain\ApplicationId;
use App\Quiz\Domain\Repository\ExamRepository;

class RandomExamGenerator
{
    public function __construct(
        private readonly ExamRepository $examRepository,
        private readonly ExamGenerator $examGenerator
    )
    {
    }

    public function __invoke(ApplicationId $applicationId): string
    {
        $questions = $this->examRepository->findRandomQuestions($applicationId);
        shuffle($questions);
        return $this->examGenerator->__invoke(
            array_slice($questions, 0, 110),
            false,
            false
        );
    }


}