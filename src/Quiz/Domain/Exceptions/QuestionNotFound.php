<?php


namespace App\Quiz\Domain\Exceptions;


use App\Quiz\Domain\ApplicationId;
use Symfony\Component\HttpFoundation\Response;

class QuestionNotFound extends \Exception
{
    public function __construct(string $questionId)
    {
        parent::__construct(
            sprintf('Questions with id %s not found', $questionId)
        );
    }
}