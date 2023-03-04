<?php

namespace App\Quiz\Application;

use App\Entity\CMSUser;

final class CreateOwnQuestionRequest
{
    public function __construct(
        private readonly CMSUser $user,
        private readonly string $question,
        private readonly string $a,
        private readonly string $b,
        private readonly string $c,
        private readonly string $d,
        private readonly string $answer
    )
    {
    }

    public function user(): CMSUser
    {
        return $this->user;
    }

    public function question(): string
    {
        return $this->question;
    }

    public function a(): string
    {
        return $this->a;
    }

    public function b(): string
    {
        return $this->b;
    }

    public function c(): string
    {
        return $this->c;
    }

    public function d(): string
    {
        return $this->d;
    }

    public function answer(): string
    {
        return $this->answer;
    }

}