<?php

namespace App\Bizkaibus\Domain;

final class Bus
{
    public function __construct(
        public readonly string $line,
        public readonly string $destiny,
        public readonly int $minutes
    )
    {
    }


    public function __toString(): string
    {
        return sprintf('%s con destino %s en %s minutos',
            $this->line,
            $this->destiny,
            $this->minutes
        );
    }


}