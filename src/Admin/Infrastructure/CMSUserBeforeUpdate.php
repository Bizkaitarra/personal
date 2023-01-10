<?php

namespace App\Admin\Infrastructure;

use App\Entity\CMSUser;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class CMSUserBeforeUpdate implements EventSubscriberInterface
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => ['beforeInsert'],
            BeforeEntityUpdatedEvent::class => ['beforeUpdate'],
        ];
    }

    public function beforeInsert(BeforeEntityPersistedEvent $event)
    {
        $CMSUser = $event->getEntityInstance();
        if (!($CMSUser instanceof CMSUser)) {
            return;
        }
        $this->hashPassword($CMSUser);


    }

    public function beforeUpdate(BeforeEntityUpdatedEvent $event)
    {
        $CMSUser = $event->getEntityInstance();
        if (!($CMSUser instanceof CMSUser)) {
            return;
        }

        if ($CMSUser->changePassword()) {
            $this->hashPassword($CMSUser);
        }
    }

    private function hashPassword(CMSUser $CMSUser)
    {

        $plaintextPassword = $CMSUser->getPassword();
        $hashedPassword = $this->userPasswordHasher->hashPassword(
            $CMSUser,
            $plaintextPassword
        );
        $CMSUser->setPassword($hashedPassword);

    }
}