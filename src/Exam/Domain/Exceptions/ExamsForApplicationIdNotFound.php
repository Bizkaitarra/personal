<?php


namespace App\Exam\Domain\Exceptions;


use App\Exam\Domain\ApplicationId;

class ExamsForApplicationIdNotFound extends \Exception
{
    public function __construct(ApplicationId $applicationId)
    {
        parent::__construct(
            sprintf('Exams not found for Application ID %s', $applicationId->value())
        );
    }
}