<?php

namespace App\Quiz\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class HomeController extends AbstractController
{
    private SessionInterface $session;

    public function __construct(
        RequestStack $requestStack
    )
    {
        $this->session = $requestStack->getSession();
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