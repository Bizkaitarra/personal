<?php

namespace App\SchoolMenu\Application;

use App\SchoolMenu\Domain\AlexaMenuDay;
use DateTime;
use App\SchoolMenu\Domain\Repository\MenuRepository;
use App\Shared\Domain\CurrentDateProvider;

class AlexaNextMenuFinder
{
    const MAX_DAYS_IN_RESPONSE = 2;
    private MenuRepository $menuRepository;
    private DateTime $today;

    public function __construct(
        MenuRepository $menuRepository,
        CurrentDateProvider $currentDateProvider
    )
    {
        $this->menuRepository = $menuRepository;
        $this->today = $currentDateProvider->getTodayAtMidnight();
    }

    public function __invoke(): string
    {
        $menus = $this->menuRepository->getMenusAfterDate($this->today, self::MAX_DAYS_IN_RESPONSE);
        if (count($menus) === 0) {
            return 'No tengo ningún menú cargado en este momento.';
        }
        $message = 'Atención que ya viene el menú.';
        foreach ($menus as $menu) {
            if ($menu instanceof AlexaMenuDay) {
                $message .= $menu->getMessage();
            }
        }
        return $message;
    }


}