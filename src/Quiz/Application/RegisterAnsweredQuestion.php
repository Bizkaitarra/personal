<?php

namespace App\Quiz\Application;

use App\Entity\AnsweredQuestion;
use App\Exam\Domain\Question;
use App\Exam\Domain\Repository\AnsweredQuestionRepository;
use App\Exam\Domain\Repository\QuestionRepository;
use App\Security\Domain\Repository\CMSUserRepository;
use DateTime;

class RegisterAnsweredQuestion
{
    public function __construct(
        private readonly AnsweredQuestionRepository $answeredQuestionRepository,
        private readonly CMSUserRepository $CMSUserRepository,
        private readonly QuestionRepository $questionRepository,
    )
    {
    }

    public function __invoke(
        DateTime $date,
        Question $answeredQuestion,
        string   $answeredLetter,
        string   $userEmail,
    )
    {
        $answeredQuestion = AnsweredQuestion::create(
            $this->questionRepository->find($answeredQuestion->getQuestionId()),
            $this->CMSUserRepository->find($userEmail),
            $date,
            Question::transformLetterAnswerToNumber($answeredLetter)
        );
        $this->answeredQuestionRepository->save($answeredQuestion);
    }

}