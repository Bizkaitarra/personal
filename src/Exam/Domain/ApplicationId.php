<?php


namespace App\Exam\Domain;


class ApplicationId
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }


    public function value():string
    {
        return $this->value;
    }


}