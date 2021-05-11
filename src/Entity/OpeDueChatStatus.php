<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 *
 */
class OpeDueChatStatus
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=TelegramUser::class, inversedBy="chatStatus", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $telegramUser;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class)
     */
    private $currentQuestion;

    /**
     * @ORM\ManyToMany(targetEntity=Question::class)
     * @ORM\JoinTable(name="failedQuestions")
     */
    private $failQuestions;

    /**
     * @ORM\ManyToMany(targetEntity=Question::class)
     * @ORM\JoinTable(name="correctQuestions")
     */
    private $correctQuestions;

    /**
     * @ORM\ManyToMany(targetEntity=Question::class)
     * @ORM\JoinTable(name="passedQuestions")
     */
    private $passQuestions;

    public function __construct(TelegramUser $telegramUser)
    {
        $this->telegramUser = $telegramUser;
        $this->failQuestions = new ArrayCollection();
        $this->correctQuestions = new ArrayCollection();
        $this->passQuestions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTelegramUser(): ?TelegramUser
    {
        return $this->telegramUser;
    }

    public function setTelegramUser(TelegramUser $telegramUser): self
    {
        $this->telegramUser = $telegramUser;

        return $this;
    }

    public function getCurrentQuestion(): ?Question
    {
        return $this->currentQuestion;
    }

    public function setCurrentQuestion(?Question $currentQuestion): self
    {
        $this->currentQuestion = $currentQuestion;

        return $this;
    }

    /**
     * @return Collection|Question[]
     */
    public function getFailQuestions(): Collection
    {
        return $this->failQuestions;
    }

    public function addFailQuestion(Question $failQuestion): self
    {
        if (!$this->failQuestions->contains($failQuestion)) {
            $this->failQuestions[] = $failQuestion;
        }

        return $this;
    }

    public function removeFailQuestion(Question $failQuestion): self
    {
        $this->failQuestions->removeElement($failQuestion);

        return $this;
    }

    /**
     * @return Collection|Question[]
     */
    public function getCorrectQuestions(): Collection
    {
        return $this->correctQuestions;
    }

    public function addCorrectQuestion(Question $correctQuestion): self
    {
        if (!$this->correctQuestions->contains($correctQuestion)) {
            $this->correctQuestions[] = $correctQuestion;
        }

        return $this;
    }

    public function removeCorrectQuestion(Question $correctQuestion): self
    {
        $this->correctQuestions->removeElement($correctQuestion);

        return $this;
    }

    /**
     * @return Collection|Question[]
     */
    public function getPassQuestions(): Collection
    {
        return $this->passQuestions;
    }

    public function addPassQuestion(Question $passQuestion): self
    {
        if (!$this->passQuestions->contains($passQuestion)) {
            $this->passQuestions[] = $passQuestion;
        }

        return $this;
    }

    public function removePassQuestion(Question $passQuestion): self
    {
        $this->passQuestions->removeElement($passQuestion);

        return $this;
    }
}
