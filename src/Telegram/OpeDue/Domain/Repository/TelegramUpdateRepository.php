<?php


namespace App\Telegram\OpeDue\Domain\Repository;


interface TelegramUpdateRepository
{
    public function getLastUpdateId():?int;
}