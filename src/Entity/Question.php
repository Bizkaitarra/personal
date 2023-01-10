<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity
 */
class Question
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="ordering", type="integer", nullable=false)
     */
    private $ordering;

    /**
     * @var bool
     *
     * @ORM\Column(name="state", type="boolean", nullable=false)
     */
    private $state;

    /**
     * @var int
     *
     * @ORM\Column(name="number", type="integer", nullable=false)
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="question", type="string", length=255, nullable=false)
     */
    private $question;

    /**
     * @var string
     *
     * @ORM\Column(name="a", type="string", length=255, nullable=false)
     */
    private $a;

    /**
     * @var string
     *
     * @ORM\Column(name="b", type="string", length=255, nullable=false)
     */
    private $b;

    /**
     * @var string
     *
     * @ORM\Column(name="c", type="string", length=255, nullable=false)
     */
    private $c;

    /**
     * @var string
     *
     * @ORM\Column(name="d", type="string", length=255, nullable=false)
     */
    private $d;

    /**
     * @var string
     *
     * @ORM\Column(name="answer", type="string", length=255, nullable=false)
     */
    private $answer;

    /**
     * @ORM\ManyToOne(targetEntity=Exam::class, inversedBy="questions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $exam;

    /**
     * @ORM\Column(name="detailedAnswer", type="string", nullable=false)
     */
    private $detailedAnswer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getOrdering(): ?int
    {
        return $this->ordering;
    }

    public function setOrdering(int $ordering): self
    {
        $this->ordering = $ordering;

        return $this;
    }

    public function getState(): ?bool
    {
        return $this->state;
    }

    public function setState(bool $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }
    
    public function getQuestionTextWithoutQuestionNumber(): ?string {

        $question = $this->question;

        if (!is_numeric(substr($question, 0, 1))) {
            return $question;
        }
        
        $numericPartOffset = 1;
        while(is_numeric(substr($question, 0,$numericPartOffset+1))) {
            $numericPartOffset++;
        }

        $question = substr($question, $numericPartOffset);

        if (str_starts_with($question, ".")) {
            $question = substr($question, 1);
        }

        return $question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getA(): ?string
    {
        return $this->a;
    }

    public function setA(string $a): self
    {
        $this->a = $a;

        return $this;
    }

    public function getB(): ?string
    {
        return $this->b;
    }

    public function setB(string $b): self
    {
        $this->b = $b;

        return $this;
    }

    public function getC(): ?string
    {
        return $this->c;
    }

    public function setC(string $c): self
    {
        $this->c = $c;

        return $this;
    }

    public function getD(): ?string
    {
        return $this->d;
    }

    public function setD(string $d): self
    {
        $this->d = $d;

        return $this;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function getDetailedAnswer(): ?string
    {
        return $this->detailedAnswer;
    }

    public function setDetailedAnswer(string $detailedAnswer): self
    {
        $this->detailedAnswer = $detailedAnswer;

        return $this;
    }

    public function getExam(): ?Exam
    {
        return $this->exam;
    }

    public function setExam(?Exam $exam): self
    {
        $this->exam = $exam;

        return $this;
    }

    public function getExamName():string
    {
        if ($this->exam === null) {
            return '';
        }
        return $this->exam->getName();
    }

    public function isCorrectAnswer(string $text)
    {
        return strtoupper($text) === strtoupper($this->getTextAnswer());
    }

    public function getTextAnswer():string
    {
        return match ($this->answer) {
            "1" => 'A',
            "2" => 'B',
            "3" => 'C',
            "4" => 'D',
            default => '-',
        };
    }

    public function getApplication(): ?int
    {
        if ($this->exam instanceof Exam) {
            return $this->exam->getApplication();
        }
        return null;
    }


}
