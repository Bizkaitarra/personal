<?php

namespace App\Quiz\Infrastructure\Controller;

use App\Exam\Application\RamdomQuestionFinder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class HomeController extends AbstractController
{
    private RamdomQuestionFinder $ramdomQuestionFinder;
    private SessionInterface $session;

    public function __construct(
        RamdomQuestionFinder $ramdomQuestionFinder,
        SessionInterface $session
    )
    {
        $this->ramdomQuestionFinder = $ramdomQuestionFinder;
        $this->session = $session;
    }


    public function __invoke(Request $request)
    {
        if ($request->getMethod() === 'POST' && $request->request->has('applicationId')) {
            $this->session->set('applicationId', $request->request->get('applicationId'));
            return $this->redirectToRoute('quiz_question');
        }
        return $this->render('quiz_home.html.twig');
    }

}