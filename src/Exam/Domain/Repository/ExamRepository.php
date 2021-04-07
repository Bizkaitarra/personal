<?php


namespace App\Exam\Domain\Repository;


use App\Exam\Domain\ApplicationId;

interface ExamRepository
{
    public function findByApplication(ApplicationId $applicationId):array;
}