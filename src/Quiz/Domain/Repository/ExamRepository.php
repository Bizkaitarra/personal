<?php


namespace App\Quiz\Domain\Repository;

use App\Quiz\Domain\ApplicationId;

interface ExamRepository
{
    public function findByApplication(ApplicationId $applicationId):array;
    public function findRandomQuestions(ApplicationId $applicationId): array;
}