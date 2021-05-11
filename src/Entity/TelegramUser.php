<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class TelegramUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $bot;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $FirstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Username;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $languageCode;

    /**
     * @ORM\OneToOne(targetEntity=OpeDueChatStatus::class, mappedBy="telegramUser", cascade={"persist", "remove"})
     */
    private $chatStatus;

    public function __construct($id, $bot, $FirstName, $Username, $languageCode)
    {
        $this->id = $id;
        $this->bot = $bot;
        $this->FirstName = $FirstName;
        $this->Username = $Username;
        $this->languageCode = $languageCode;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBot(): ?bool
    {
        return $this->bot;
    }

    public function setBot(bool $bot): self
    {
        $this->bot = $bot;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    public function setFirstName(?string $FirstName): self
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->Username;
    }

    public function setUsername(?string $Username): self
    {
        $this->Username = $Username;

        return $this;
    }

    public function getLanguageCode(): ?string
    {
        return $this->languageCode;
    }

    public function setLanguageCode(?string $languageCode): self
    {
        $this->languageCode = $languageCode;

        return $this;
    }

    public function getChatStatus(): ?OpeDueChatStatus
    {
        return $this->chatStatus;
    }

    public function setChatStatus(OpeDueChatStatus $chatStatus): self
    {
        // set the owning side of the relation if necessary
        if ($chatStatus->getTelegramUser() !== $this) {
            $chatStatus->setTelegramUser($this);
        }

        $this->chatStatus = $chatStatus;

        return $this;
    }
}
