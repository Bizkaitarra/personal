<?php


namespace App\BloodDonors\Domain\Exception;


class ApiException extends \Exception
{
    private const MESSAGE = 'Blood donour API error';

    /**
     * ApiException constructor.
     */
    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }


}