<?php


namespace App\Tests\Domain;


use App\Entity\Question;

class QuestionMother
{
    public static function generateRandomQuestion() {
        $question = new Question();
        return $question;
    }
}