<?php

namespace App\Exam\Domain;

interface HTMLToPDFRender
{
    public function getStream(string $html) :void;
}