<?php

namespace App\Bizkaibus\Domain;

final class StopCode
{
    public readonly string $value;

    public function __construct(string $stopCode)
    {
        $this->value = str_pad($stopCode, 4, '0', STR_PAD_LEFT);
    }
}