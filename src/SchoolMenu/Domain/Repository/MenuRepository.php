<?php

namespace App\SchoolMenu\Domain\Repository;

use DateTime;

interface MenuRepository
{
    public function getLastDayWithMenu():?DateTime;
    public function getMenusAfterDate(DateTime $date, int $limit):?array;
}