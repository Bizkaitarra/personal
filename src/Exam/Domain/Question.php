<?php


namespace App\Exam\Domain;


class Question
{
    private string $exam;
    private string $number;
    private string $question;
    private string $a;
    private string $b;
    private string $c;
    private string $d;
    private string $answer;

    public function __construct(
        string $exam,
        string $number,
        string $question,
        string $a,
        string $b,
        string $c,
        string $d,
        string $answer)
    {
        $this->exam = $exam;
        $this->number = $number;
        $this->question = $question;
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
        $this->d = $d;
        $this->answer = $answer;
    }

    /**
     * @return string
     */
    public function getExam(): string
    {
        return $this->exam;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->question;
    }

    /**
     * @return string
     */
    public function getA(): string
    {
        return $this->a;
    }

    /**
     * @return string
     */
    public function getB(): string
    {
        return $this->b;
    }

    /**
     * @return string
     */
    public function getC(): string
    {
        return $this->c;
    }

    /**
     * @return string
     */
    public function getD(): string
    {
        return $this->d;
    }

    /**
     * @return string
     */
    public function getAnswer(): string
    {
        return $this->answer;
    }

    public function isCorrectLetterAnswer(string $letter): bool
    {
        $letters = [
            1=>'A',
            2=>'B',
            3=>'C',
            4=>'D'
        ];
        return $letters[$this->answer] === $letter;

    }

    public function getLetterAnswer(): string
    {
        $letters = [
            1=>'A',
            2=>'B',
            3=>'C',
            4=>'D'
        ];
        return $letters[$this->answer];
    }

}