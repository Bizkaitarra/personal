<?php


namespace App\Quiz\Domain\Exceptions;


use App\Quiz\Domain\ApplicationId;

class ExamsForApplicationIdNotFound extends \Exception
{
    public function __construct(ApplicationId $applicationId)
    {
        parent::__construct(
            sprintf('Exams not found for Application ID %s', $applicationId->value())
        );
    }
}