<?php

namespace App\Quiz\Domain;

interface HTMLToPDFRender
{
    public function getStream(string $html) :void;
}