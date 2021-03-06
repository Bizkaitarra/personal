<?php

namespace App\Shared\Domain;

use DateTime;

class CurrentDateProvider
{
    public function getCurrentDatetime(): DateTime
    {
        return new DateTime();
    }

    public function getTodayAtMidnight(): DateTime {
        $today = new DateTime();
        return DateTime::createFromFormat(
            'Y-m-d H:i:s',
            sprintf(
                "%s 00:00:00",
                $today->format('Y-m-d'))
        );
    }

}