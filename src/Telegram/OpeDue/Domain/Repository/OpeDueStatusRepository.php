<?php


namespace App\Telegram\OpeDue\Domain\Repository;


use App\Entity\OpeDueChatStatus;

interface OpeDueStatusRepository
{
    public function save(OpeDueChatStatus $opeDueChatStatus):void;
}