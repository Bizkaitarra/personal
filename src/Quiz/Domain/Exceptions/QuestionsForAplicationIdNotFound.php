<?php


namespace App\Quiz\Domain\Exceptions;


use App\Quiz\Domain\ApplicationId;
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