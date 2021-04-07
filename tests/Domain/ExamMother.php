<?php


namespace App\Tests\Domain;


use App\Entity\Exam;

class ExamMother
{
    public static function generateRandomExam() {
        $exam = new Exam();
        $exam->setName('ramdom');
        $exam->setType('2');
        $exam->setApplication(4);
        $exam->setDescription('');
        return $exam;
    }
}