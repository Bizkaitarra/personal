<?php

namespace App\Quiz\Infrastructure\EventSubscribers;

use App\Quiz\Application\RegisterAnsweredQuestion;
use App\Quiz\Domain\Events\QuestionHasBeenAnswered;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RegisterAnsweredQuestionSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly RegisterAnsweredQuestion $registerAnsweredQuestion
    )
    {
    }


    public function registerQuestionAnswer(QuestionHasBeenAnswered $event)
    {
        $this->registerAnsweredQuestion->__invoke(
            $event->date,
            $event->question,
            $event->answeredLetter,
            $event->userEmail,
        );
    }

    public static function getSubscribedEvents(): array
    {
        return [
            QuestionHasBeenAnswered::class => 'registerQuestionAnswer',
        ];
    }
}