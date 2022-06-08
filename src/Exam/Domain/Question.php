<?php


namespace App\Exam\Domain;


class Question
{
    public function __construct(
        private readonly string $questionId,
        private readonly string $exam,
        private readonly string $number,
        private readonly string $question,
        private readonly string $a,
        private readonly string $b,
        private readonly string $c,
        private readonly string $d,
        private readonly string $answer
    )
    {
    }

    /**
     * @return string
     */
    public function getQuestionId(): string
    {
        return $this->questionId;
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
            1 => 'A',
            2 => 'B',
            3 => 'C',
            4 => 'D'
        ];
        return $letters[$this->answer] === $letter;

    }

    public function getLetterAnswer(): ?string
    {
        return self::transformNumberAnswerToLetter($this->answer);
    }

    public static function transformNumberAnswerToLetter(?int $answer): ?string
    {
        if (!is_numeric($answer)) {
            return null;
        }

        $transformationArray = [
            1 => 'A',
            2 => 'B',
            3 => 'C',
            4 => 'D'
        ];
        return $transformationArray[$answer];
    }

    public static function transformLetterAnswerToNumber(?string $answer): ?int
    {
        if ($answer === null) {
            return null;
        }

        $transformationArray = [
            'A' => 1,
            'B' => 2,
            'C' => 3,
            'D' => 4
        ];
        return $transformationArray[$answer];
    }

}