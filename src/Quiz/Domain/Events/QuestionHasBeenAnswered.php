<?php

namespace App\Quiz\Domain\Events;

use App\Exam\Domain\Question;
use DateTime;
use Symfony\Contracts\EventDispatcher\Event;

class QuestionHasBeenAnswered extends Event
{
    public function __construct(
        public readonly DateTime $date,
        public readonly Question $question,
        public readonly string   $answeredLetter,
        public readonly string   $userEmail,
    )
    {
    }
}