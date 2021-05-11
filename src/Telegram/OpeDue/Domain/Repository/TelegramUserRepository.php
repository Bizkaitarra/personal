<?php


namespace App\Telegram\OpeDue\Domain\Repository;


use App\Entity\TelegramUser;

interface TelegramUserRepository
{
    public function getTelegramUser(int $userId, bool $isBot, ?string $firstName, ?string $username, string $languageCode):TelegramUser;
}