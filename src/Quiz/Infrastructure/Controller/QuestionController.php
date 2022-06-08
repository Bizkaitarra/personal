<?php

namespace App\Quiz\Infrastructure\Controller;

use App\Exam\Application\RamdomQuestionFinder;
use App\Exam\Domain\ApplicationId;
use App\Exam\Domain\Exceptions\ExamsForApplicationIdNotFound;
use App\Exam\Domain\Exceptions\QuestionsForAplicationIdNotFound;
use App\Exam\Domain\Question;
use App\Quiz\Domain\Events\QuestionHasBeenAnswered;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class QuestionController extends AbstractController
{
    private SessionInterface $session;

    public function __construct(
        private readonly RamdomQuestionFinder $randomQuestionFinder,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly Security $security,
        RequestStack                          $requestStack
    )
    {
        $this->session = $requestStack->getSession();
    }


    public function __invoke(Request $request)
    {
        $applicationId = $this->session->get('applicationId');

        $question = $this->session->get('lastQuestion');
        if ($request->getMethod() === 'POST' && $request->request->has('answer') && $question instanceof Question) {
            $answer = $request->request->get('answer');
            $this->eventDispatcher->dispatch(new QuestionHasBeenAnswered(
                new \DateTime(),
                $question,
                $answer,
                $this->security->getUser()->getUserIdentifier(),
            ));
            return $this->render(
                'quiz_question_answer.html.twig',
                [
                    'question' => $question,
                    'playerAnswer' => $answer,
                    'isSuccess' => $question->isCorrectLetterAnswer($answer)
                ]
            );
        }


        try {
            $question = $this->randomQuestionFinder->__invoke(new ApplicationId($applicationId));
        } catch (ExamsForApplicationIdNotFound | QuestionsForAplicationIdNotFound $e) {
            return $this->render('quiz_no_questions.html.twig');
        }

        $this->session->set('lastQuestion', $question);

        return $this->render(
            'quiz_question.html.twig',
            ['question' => $question]
        );
    }

}