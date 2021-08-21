<?php


namespace App\BloodDonors\Domain;


class Place
{
    private string $value;

    public function __construct(string $value)
    {
        switch (ucfirst(strtolower($value))) {
            case 'Bisauri':
            case 'Bisaurri':
            case 'Visaurri':
            case 'Bisarr':
            case 'Bisaurr':
            case 'Valladolid':
                $value = 'Basauri';
                break;
            case 'Baracaldo':
                $value = 'Barakaldo';
                break;
            case 'Santurce':
            case 'Santurchi':
                $value = 'Santurtzi';
                break;
            case 'Bilbo':
            case null:
            case '':
                $value = 'Bilbao';
                break;
        }
        $this->value = $value;
    }


    public function getValue(): string
    {
        return $this->value;
    }




}