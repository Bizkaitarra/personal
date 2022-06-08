<?php

namespace App\Entity;

use App\Repository\AnsweredQuestionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class AnsweredQuestion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $question;

    /**
     * @ORM\ManyToOne(targetEntity=CMSUser::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $answeredNumber;

    public static function create(
        $question,
        $user,
        $date,
        $answeredNumber
    ): AnsweredQuestion
    {
        $self = new self();
        $self->question = $question;
        $self->user = $user;
        $self->date = $date;
        $self->answeredNumber = $answeredNumber;
        return $self;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getUser(): ?CMSUser
    {
        return $this->user;
    }

    public function setUser(?CMSUser $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAnsweredNumber(): ?int
    {
        return $this->answeredNumber;
    }

    public function setAnsweredNumber(?int $answeredNumber): self
    {
        $this->answeredNumber = $answeredNumber;

        return $this;
    }
}
