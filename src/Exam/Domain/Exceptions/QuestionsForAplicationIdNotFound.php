<?php


namespace App\Exam\Domain\Exceptions;


use App\Exam\Domain\ApplicationId;
use Symfony\Component\HttpFoundation\Response;

class QuestionsForAplicationIdNotFound extends \Exception
{
    public function __construct(ApplicationId $applicationId)
    {
        parent::__construct(
            sprintf('Questions not found for Application ID %s', $applicationId->value())
        );
    }
}