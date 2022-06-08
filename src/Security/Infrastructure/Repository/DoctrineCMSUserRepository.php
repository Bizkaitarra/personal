<?php

namespace App\Security\Infrastructure\Repository;

use App\Entity\CMSUser;
use App\Security\Domain\Repository\CMSUserRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineCMSUserRepository implements CMSUserRepository
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    public function find(string $email): CMSUser
    {
        return $this->entityManager->getRepository(CMSUser::class)->findOneBy(
            ['email' => $email]
        );
    }
}