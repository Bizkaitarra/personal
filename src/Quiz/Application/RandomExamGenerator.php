<?php

namespace App\Quiz\Application;

use App\Entity\Question;
use App\Quiz\Domain\ApplicationId;
use App\Quiz\Domain\Repository\ExamRepository;

class RandomExamGenerator
{
    public function __construct(
        private readonly ExamRepository $examRepository
    )
    {
    }


    public function __invoke(ApplicationId $applicationId): string
    {
        $questions = $this->examRepository->findRandomQuestions($applicationId);

        shuffle($questions);

        $html ='<!DOCTYPE html><html><head><title>Exámen de prueba</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>';

        $html .='<body><h1>Exámen aleatorio</h1>';
        $html .='<p>Atención: Después de la última pregunta vienen las soluciones y después de las soluciones viene un listado de los origenes de las preguntas por si crees que alguna está mal.</p>';


        for ($currentQuestionIndex = 0; $currentQuestionIndex<110; $currentQuestionIndex++) {
            /** @var Question $currentQuestion */
            $currentQuestion = $questions[$currentQuestionIndex];

            $questionText = ($currentQuestionIndex+1) . "- " . $currentQuestion->getQuestionTextWithoutQuestionNumber();

            $html.= '<h5>'.$questionText.'</h5>';

            $html.= '<ul style="list-style-type:lower-alpha;>">';
            $html.= '<li>'. $currentQuestion->getA().'</li>';
            $html.= '<li>'. $currentQuestion->getB().'</li>';
            $html.= '<li>'. $currentQuestion->getC().'</li>';
            $html.= '<li>'. $currentQuestion->getD().'</li>';
            $html.= '</ul>';


        }

        $html.= '<div style="page-break-before: always"></div>';
        $html.= '<h2> Soluciones </h2>';

        $html.= '<div style="padding-top: 100px;">';
        $html.= $this->getSolutionAsText($questions, 0, 24);
        $html.= $this->getSolutionAsText($questions, 25, 49);
        $html.= $this->getSolutionAsText($questions, 50, 74);
        $html.= $this->getSolutionAsText($questions, 75, 99);
        $html.= $this->getSolutionAsText($questions, 100, 109);
        $html.= '</div>';


        $html .='</body></html>';

        return $html;
    }

    private function getSolutionAsText($questions, $min, $max) {

        $html= '<ul style="width:15%;display:inline-block;">';
        for ($numPreg = $min;$numPreg<=$max;$numPreg++) {
            /** @var Question $question */
            $question = $questions[$numPreg];
            $html.= '<li>'.($numPreg+1).' - '.$question->getTextAnswer().'</li>';
        }
        $html.= '</ul>';
        return $html;
    }

}