<?php

namespace App\Quiz\Domain\Events;

use App\Exam\Domain\Question;
use DateTime;
use Symfony\Contracts\EventDispatcher\Event;

class QuestionHasBeenAnswered extends Event
{
    private function __construct(
        public readonly DateTime $date,
        public readonly Question $question,
        public readonly string   $answeredLetter,
        public readonly string   $userEmail,
    )
    {
    }

    public static function create(
        Question $question,
        string   $answeredLetter,
        string   $userEmail
    ): QuestionHasBeenAnswered
    {
        return new self(
            new \DateTime(),
            $question,
            $answeredLetter,
            $userEmail
        );
    }
}