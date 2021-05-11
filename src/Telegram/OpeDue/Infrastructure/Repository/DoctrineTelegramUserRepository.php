<?php


namespace App\Telegram\OpeDue\Infrastructure\Repository;


use App\Entity\TelegramUser;
use App\Telegram\OpeDue\Domain\Repository\TelegramUserRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineTelegramUserRepository implements TelegramUserRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function getTelegramUser(int $userId, bool $isBot, ?string $firstName, ?string $username, string $languageCode): TelegramUser
    {
        $telegramUser = $this->entityManager->getRepository(TelegramUser::class)->find($userId);
        if ($telegramUser instanceof TelegramUser) {
            return $telegramUser;
        }

        return new TelegramUser(
            $userId,
            $isBot,
            $firstName,
            $username,
            $languageCode
        );

    }
}