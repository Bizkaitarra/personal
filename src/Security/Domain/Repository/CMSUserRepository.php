<?php

namespace App\Security\Domain\Repository;

use App\Entity\CMSUser;

interface CMSUserRepository
{
    public function find(string $email):CMSUser;
}