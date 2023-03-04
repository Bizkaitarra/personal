<?php

namespace App\Quiz\Application;

use App\Entity\Question;

final class ExamGenerator
{
    public function __invoke(array $questions, bool $markAnswer = false, $excludeIncorrectOptions = false): string
    {

        $html ='<!DOCTYPE html><html><head><title>Exámen de prueba</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>';

        $html .='<body><h1>Exámen aleatorio</h1>';
        $html .='<p>Atención: Después de la última pregunta vienen las soluciones y después de las soluciones viene un listado de los origenes de las preguntas por si crees que alguna está mal.</p>';


        for ($currentQuestionIndex = 0; $currentQuestionIndex < count($questions); $currentQuestionIndex++) {
            /** @var Question $currentQuestion */
            $currentQuestion = $questions[$currentQuestionIndex];

            $questionText = ($currentQuestionIndex+1) . "- " . $currentQuestion->getQuestionTextWithoutQuestionNumber();

            $html.= '<h5>'.$questionText.'</h5>';

            $html.= '<ul>';
            $html.= $this->printOption($currentQuestion, 'A', $markAnswer, $excludeIncorrectOptions);
            $html.= $this->printOption($currentQuestion, 'B', $markAnswer, $excludeIncorrectOptions);
            $html.= $this->printOption($currentQuestion, 'C', $markAnswer, $excludeIncorrectOptions);
            $html.= $this->printOption($currentQuestion, 'D', $markAnswer, $excludeIncorrectOptions);
            $html.= '</ul>';


        }


        $questionsPerGroup = 40;
        $questionsInColumns = array_chunk($questions, $questionsPerGroup);
        $columnsPerPage = 4;
        $questionsInColumnsAndPages = array_chunk($questionsInColumns, $columnsPerPage);

        $numPreg = 1;

        foreach ($questionsInColumnsAndPages as $questionsOfPage) {
            $html.= '<div style="page-break-before: always"></div>';
            $html.= '<div style="padding-top: 120px;">';
            foreach ($questionsOfPage as $questionsOfColumn) {
                $html.= $this->getSolutionAsText($questionsOfColumn, $numPreg);
                $numPreg+= $questionsPerGroup;
            }
            $html.= '</div>';

        }
        $html .='</body></html>';

        return $html;
    }

    private function printOption(Question $question, string $option, bool $markAnswer, bool $excludeIncorrectOptions) {
        $method = 'get'.strtoupper($option);

        $isCorrectAnswer = $question->isCorrectAnswer(strtoupper($option));

        if ($isCorrectAnswer && $markAnswer) {
            $markStyle = 'font-weight: bold;';
            return sprintf("<li style='%s'>%s) %s</li>", $markStyle, $option, $question->$method());
        }

        if (!$isCorrectAnswer && $excludeIncorrectOptions) {
            return '';
        }
        return sprintf("<li>%s) %s</li>", $option, $question->$method());
    }

    private function getSolutionAsText($questions, $numPreg) {

        $html= '<ul style="width:15%;display:inline-block;">';
        /** @var Question $question */
        foreach ($questions as $question) {
            $html.= '<li>'.($numPreg).' - '.$question->getTextAnswer().'</li>';
            $numPreg++;
        }
        $html.= '</ul>';
        return $html;
    }
}