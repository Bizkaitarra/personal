<?php

namespace App\Shared\Domain;

use DateTime;

class CurrentDateProvider
{
    public function getCurrentDatetime(): DateTime
    {
        return new DateTime();
    }

}