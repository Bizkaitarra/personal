<?php


namespace App\Exam\Domain\Exceptions;


use App\Exam\Domain\ApplicationId;
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