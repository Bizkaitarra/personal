<?php

namespace App\Quiz\Infrastructure\Controller;

use App\Quiz\Application\RamdomQuestionFinder;
use App\Quiz\Domain\ApplicationId;
use App\Quiz\Domain\Exceptions\ExamsForApplicationIdNotFound;
use App\Quiz\Domain\Exceptions\QuestionsForAplicationIdNotFound;
use App\Quiz\Domain\Question;
use App\Quiz\Domain\Events\QuestionHasBeenAnswered;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class QuestionController extends AbstractController
{
    private SessionInterface $session;

    public function __construct(
        private readonly RamdomQuestionFinder     $randomQuestionFinder,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly Security                 $security,
        RequestStack                              $requestStack
    )
    {
        $this->session = $requestStack->getSession();
    }


    public function __invoke(Request $request): Response
    {
        if (!$this->session->has('applicationId')) {
            return $this->redirectToRoute('quiz_index');
        }
        $applicationId = $this->session->get('applicationId');

        $question = $this->session->get('lastQuestion');
        $previousAnsweredQuestions = $this->session->get('questions', []);

        if ($question instanceof Question) {
            if (!in_array($question->getUniqueId(), $previousAnsweredQuestions)) {
                $previousAnsweredQuestions[] = $question->getUniqueId();
                $this->session->set('questions', $previousAnsweredQuestions);
            }
        }

        $correctQuestions = $this->session->get('correctQuestions', []);
        $failedQuestions = $this->session->get('failedQuestions', []);

        if ($request->getMethod() === 'POST' && $request->request->has('answer') && $question instanceof Question) {
            $answer = $request->request->get('answer');
            $isCorrectLetterAnswer = $question->isCorrectLetterAnswer($answer);

            if ($isCorrectLetterAnswer) {
                $correctQuestions[] = $question;
                $this->session->set('correctQuestions', $correctQuestions);
            } else {
                $failedQuestions[] = $question;
                $this->session->set('failedQuestions', $failedQuestions);
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

        $this->session->set('lastQuestion', $question);

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