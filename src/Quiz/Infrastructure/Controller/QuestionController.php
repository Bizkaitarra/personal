<?php

namespace App\Quiz\Infrastructure\Controller;

use App\Quiz\Application\RandomQuestionFinder;
use App\Quiz\Domain\ApplicationId;
use App\Quiz\Domain\Events\QuestionHasBeenAnswered;
use App\Quiz\Domain\Exceptions\ExamsForApplicationIdNotFound;
use App\Quiz\Domain\Exceptions\QuestionsForAplicationIdNotFound;
use App\Quiz\Domain\Question;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class QuestionController extends AbstractController
{

    public function __construct(
        private readonly RandomQuestionFinder     $randomQuestionFinder,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly Security                 $security,
        private RequestStack                      $requestStack
    )
    {
    }


    public function __invoke(Request $request): Response
    {
        $session = $this->requestStack->getSession();
        if (!$session->has('applicationId')) {
            return $this->redirectToRoute('quiz_index');
        }
        $applicationId = $session->get('applicationId');

        $question = $session->get('lastQuestion');
        $previousAnsweredQuestions = $session->get('questions', []);

        if ($question instanceof Question) {
            if (!in_array($question->getUniqueId(), $previousAnsweredQuestions)) {
                $previousAnsweredQuestions[] = $question->getUniqueId();
                $session->set('questions', $previousAnsweredQuestions);
            }
        }

        $correctQuestions = $session->get('correctQuestions', []);
        $failedQuestions = $session->get('failedQuestions', []);

        if ($request->getMethod() === 'POST' && $request->request->has('answer') && $question instanceof Question) {
            $answer = $request->request->get('answer');
            $isCorrectLetterAnswer = $question->isCorrectLetterAnswer($answer);

            if ($isCorrectLetterAnswer) {
                $correctQuestions[] = $question;
                $session->set('correctQuestions', $correctQuestions);
            } else {
                $failedQuestions[] = $question;
                $session->set('failedQuestions', $failedQuestions);
            }

            $this->eventDispatcher->dispatch(
                QuestionHasBeenAnswered::create(
                    $question,
                    $answer,
                    $this->security->getUser()->getUserIdentifier(),
                )
            );

            return $this->render(
                'quiz_question_answer.html.twig',
                [
                    'question' => $question,
                    'playerAnswer' => $answer,
                    'isSuccess' => $isCorrectLetterAnswer,
                    'correctsCount' => count($correctQuestions),
                    'failedCount' => count($failedQuestions),
                    'correctQuestions' => $correctQuestions,
                    'failedQuestions' => $failedQuestions,
                ]
            );
        }
        try {
            $question = $this->randomQuestionFinder->__invoke(
                new ApplicationId($applicationId),
                $previousAnsweredQuestions
            );
        } catch (ExamsForApplicationIdNotFound|QuestionsForAplicationIdNotFound $e) {
            return $this->render('quiz_no_questions.html.twig');
        }

        $session->set('lastQuestion', $question);

        return $this->render(
            'quiz_question.html.twig',
            [
                'question' => $question,
                'correctsCount' => count($correctQuestions),
                'failedCount' => count($failedQuestions),
                'correctQuestions' => $correctQuestions,
                'failedQuestions' => $failedQuestions,
            ]
        );
    }

}